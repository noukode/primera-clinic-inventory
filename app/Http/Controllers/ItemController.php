<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use App\Models\Unit;
use Illuminate\Http\Request;
use Throwable;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Item List';
        $units = Unit::get();
        $categories = Category::get();
        $items = Item::with('category', 'unit')->withSum('stock', 'quantity');
        if(request('unit_id')){
            $items = $items->where('unit_id', request('unit_id'));
        }

        if(request('category_id')){
            $items = $items->where('category_id', request('category_id'));
        }

        if(request('search')){
            $items = $items->where('name', 'LIKE', '%'. request('search') .'%')->orWhere('kode_item', 'LIKE', '%'. request('search') .'%');
        }

        $items = $items->paginate(15);
        return view('pages.item.index', compact('title', 'items', 'units', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Create Item';
        $categories = Category::get();
        $units = Unit::get();

        return view('pages.item.create', compact('title', 'categories', 'units'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'category_id' => 'required|integer|exists:categories,id',
            'unit_id' => 'required|integer|exists:units,id'
        ]);

        $latest_code = Item::select('kode_item')->orderBy('kode_item', 'DESC')->first();

        $item_code = 'A-01';
        if($latest_code){
            $last_digit = explode('-', $latest_code->kode_item)[1];
            $item_code = 'A-' . sprintf('%02d', $last_digit+1);
        }

        Item::create([
            'kode_item' => $item_code,
            'name' => $validated['name'],
            'description' => $validated['description'],
            'category_id' => $validated['category_id'],
            'unit_id' => $validated['unit_id'],
        ]);

        return redirect('/item')->withSuccess([
            'status' => 'success',
            'message' => 'Berhasil tambah data'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        $item = $item->with('category', 'unit')->withSum('stock', 'quantity')->first();
        return view('pages.item.read', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        $title = 'Edit Item';
        $item = $item->with('category', 'unit')->withSum('stock', 'quantity')->first();
        $categories = Category::get();
        $units = Unit::get();

        return view('pages.item.edit', compact('title', 'item', 'categories', 'units'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'category_id' => 'required|integer|exists:categories,id',
            'unit_id' => 'required|integer|exists:units,id'
        ]);

        $item->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'category_id' => $validated['category_id'],
            'unit_id' => $validated['unit_id'],
        ]);

        return redirect('/item')->withSuccess([
            'status' => 'success',
            'message' => 'Berhasil update data'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        try{
            $item->delete();

            return response()->json([
                'status' => 'success',
                'error' => 0,
                'message' => 'Berhasil hapus data',
            ]);
        }catch(Throwable $e){
            return response()->json([
                'status' => 'error',
                'error' => 1,
                'message' => 'Gagal hapus data'
            ], 400);
        }
    }

    public function get($id)
    {
        $item = Item::with('unit', 'category')->where('id', $id)->first();
        if($item){
            return response()->json([
                'status' => 'success',
                'error' => 0,
                'message' => 'Success',
                'data' => $item
            ]);
        }

        return response()->json([
            'status' => 'success',
            'error' => 0,
            'message' => 'Success',
            'data' => $item
        ], 404);
    }

    public function all()
    {
        $items = Item::with('unit', 'category')->get();

        return response()->json([
            'status' => 'success',
            'error' => 0,
            'message' => 'Success',
            'data' => $items,
            'totalCount' => $items->count()
        ]);
    }
}
