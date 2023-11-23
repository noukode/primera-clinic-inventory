<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Http\Requests\StoreBranchRequest;
use App\Http\Requests\UpdateBranchRequest;
use Throwable;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Branch List';
        $branches = Branch::select();
        if(request('search')){
            $branches = $branches->where('name', 'LIKE', '%'. request('search') . '%');
        }

        $branches = $branches->paginate(15);
        return view('pages.branch.index', compact('title', 'branches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Create Branch';
        return view('pages.branch.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBranchRequest $request)
    {
        Branch::create([
            'name' => $request->name,
            'detail' => $request->detail,
        ]);

        return redirect()->to(route('branch.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Branch $branch)
    {
        $title = 'Branch Detail';
        return view('pages.branch.edit', compact('title', 'branch'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Branch $branch)
    {
        $title = 'Edit Branch';
        return view('pages.branch.edit', compact('title', 'branch'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBranchRequest $request, Branch $branch)
    {
        $branch->name = $request->name;
        $branch->detail = $request->detail;
        $branch->save();

        return redirect()->to(route('branch.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Branch $branch)
    {
        try{
            $branch->delete();

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
