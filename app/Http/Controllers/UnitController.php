<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use Throwable;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = 'Unit List';
        $units = new Unit();
        if($request->search){
            $units = $units->where('name', 'LIKE', '%'. $request->search .'%');
        }
        $units = $units->paginate(15);
        return view('pages.unit.index', compact('title', 'units'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Create Unit";
        return view('pages.unit.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            // 'slug' => 'required|unique:unit,slug'
        ]);

        Unit::create([
            'name' => $validated['name'],
            // 'slug' => $validated['slug'],
        ]);

        return redirect()->to('unit')->withSuccess([
            'status' => 'success',
            'message' => 'Tambah data berhasil'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Unit $unit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Unit $unit)
    {
        $title = 'Edit Unit';
        return view('pages.unit.edit', compact('title', 'unit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Unit $unit)
    {
        $validated = $request->validate([
            'name' => 'required',
            // 'slug' => 'required|unique:unit,slug,' . $category->id
        ]);

        $unit->name = $validated['name'];
        // $unit->slug = $validated['slug'];
        $unit->save();

        return redirect()->to('unit')->withSuccess([
            'status' => 'success',
            'message' => 'Update data berhasil'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unit $unit)
    {
        try{
            $unit->delete();

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
