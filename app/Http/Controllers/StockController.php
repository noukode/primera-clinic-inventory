<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Http\Requests\StoreStockRequest;
use App\Http\Requests\UpdateStockRequest;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Item;
use App\Models\Location;
use App\Models\StockHistory;
use App\Models\StockType;
use App\Models\Unit;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Stock';
        $stock_types = StockType::get();
        $branches = Branch::get();
        $units = Unit::get();
        $categories = Category::get();
        $stocks = Stock::with('item')->groupBy('location_id', 'stock_type_id', 'item_id')
        ->selectRaw('sum(quantity) as sum, location_id, stock_type_id, item_id')
        // ->leftJoin('items as i', function($join){
        //     return $join->on('i.id', '=', 'stocks.item_id');
        // })
        ->with([
            'item' => function($query){
                return $query->select('id', 'kode_item', 'name', 'category_id', 'unit_id')->with([
                    'category' => function($q){
                        return $q->select('id', 'name');
                    },
                    'unit' => function($q){
                        return $q->select('id', 'name');
                    },
                ]);
            },
            'location.branch'
        ]);
        if(request('search')){
            $stocks = $stocks->orWhereHas('item', function($q){
                return $q->where('name', 'LIKE', '%'. request('search') . '%')->orWhere('kode_item', 'LIKE', '%'. request('search') . '%');
            })->orWhereHas('location', function($q){
                return $q->where('locations.name', 'LIKE', '%' . request('search') . '%');
            });
        }

        if(request('stock_type_id')){
            $stocks = $stocks->where('stock_type_id', request("stock_type_id"));
        }

        if(request('branch_id')){
            $stocks = $stocks->whereHas('location', function($q){
                return $q->where('branch_id', request('branch_id'));
            });
        }

        if(request('unit_id')){
            $stocks = $stocks->whereHas('item', function($q){
                return $q->where('unit_id', request('unit_id'));
            });
        }

        if(request('category_id')){
            $stocks = $stocks->whereHas('item', function($q){
                return $q->where('category_id', request('category_id'));
            });
        }
        $stocks = $stocks->paginate(15);
        return view('pages.stock.index', compact('title', 'stock_types', 'branches', 'units', 'categories', 'stocks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStockRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $stock)
    {
        $title = $stock->name;
        $item = $stock;
        $stock = Stock::where('item_id', $item->id);

        $stock_histories = StockHistory::select();

        $locations = Location::with('branch')->whereHas('stocks', function($query)use($item){
            return $query->where('item_id', $item->id);
        });

        $stock_types = StockType::whereHas('stocks', function($query)use($item){
            return $query->where('item_id', $item->id);
        })->get();

        $branches = Branch::get();

        $location = null;
        $stock_type = null;
        if(request('branch_id'))
        {
            $locations = $locations->where('branch_id', request('branch_id'));
            $stock = $stock->whereHas('location', function($query){
                return $query->where('branch_id', request('branch_id'));
            });
            $stock_histories = $stock_histories->where('branch_id', request('branch_id'));
        }
        if(request('location_id')){
            $location = Location::where('id', request('location_id'))->first();
            $stock = $stock->where('location_id', request('location_id'));
            $stock_histories = $stock_histories->where('location_id', request('location_id'));
        }

        if(request('stock_type')){
            $stock_type = StockType::where('id', request('stock_type'))->first();
            $stock = $stock->where('stock_type_id', request('stock_type'));
            $stock_histories = $stock_histories->where('stock_type_id', request('stock_type'));
        }

        $stock_histories = $stock_histories->orderBy('created_at', 'DESC')->paginate(15);

        $locations = $locations->get();
        $stock = $stock->get()->sum('quantity');
        return view('pages.stock.show', compact('title', 'item', 'stock', 'locations', 'location', 'stock_types', 'stock_type', 'branches', 'stock_histories'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Stock $stock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStockRequest $request, Stock $stock)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stock $stock)
    {
        //
    }
}
