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
        $items = Item::with('category', 'unit')->withSum('stock', 'quantity')->get();
        return view('pages.item.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::get();
        $units = Unit::get();

        return view('pages.item.create', compact('categories', 'units'));
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

        return redirect('/item')->with('response', [
            'status' => 'success',
            'message' => 'Berhasil melakukan perubahan data'
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
        $item = $item->with('category', 'unit')->withSum('stock', 'quantity')->first();
        $categories = Category::get();
        $units = Unit::get();

        return view('pages.item.edit', compact('item', 'categories', 'units'));
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

        return redirect('/item')->with('response', [
            'status' => 'success',
            'message' => 'Berhasil melakukan perubahan data'
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
}
