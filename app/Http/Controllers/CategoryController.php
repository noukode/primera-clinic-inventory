<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Throwable;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = new Category();
        if($request->search){
            $categories = $categories->where('name', 'LIKE', '%'. $request->search .'%');
        }
        $categories = $categories->paginate(15);
        return view('pages.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            // 'slug' => 'required|unique:categories,slug'
        ]);

        Category::create([
            'name' => $validated['name'],
            // 'slug' => $validated['slug'],
        ]);

        return redirect()->to('category')->withSuccess([
            'status' => 'success',
            'message' => 'Tambah data berhasil'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('pages.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required',
            // 'slug' => 'required|unique:categories,slug,' . $category->id
        ]);

        $category->name = $validated['name'];
        // $category->slug = $validated['slug'];
        $category->save();

        return redirect()->to('category')->withSuccess([
            'status' => 'success',
            'message' => 'Update data berhasil'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        try{
            $category->delete();

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
