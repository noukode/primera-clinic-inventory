<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Http\Requests\StoreLocationRequest;
use App\Http\Requests\UpdateLocationRequest;
use App\Models\Branch;
use Throwable;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Location List';
        $branches = Branch::get();
        $locations = Location::with('branch');
        if(request('branch_id')){
            $locations = $locations->where('branch_id', request('branch_id'));
        }

        if(request('search')){
            $locations = $locations->where('name', 'LIKE', '%'. request('search') .'%');
        }

        $locations = $locations->paginate(15);
        return view('pages.location.index', compact('title', 'locations', 'branches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Create Location';
        $branches = Branch::get();
        return view('pages.location.create', compact('title', 'branches'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLocationRequest $request)
    {
        Location::create([
            'name' => $request->name,
            'branch_id' => $request->branch_id
        ]);

        return redirect()->to(route('location.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Location $location)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Location $location)
    {
        $title = 'Update Location';
        $branches = Branch::get();
        return view('pages.location.edit', compact('title', 'branches', 'location'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLocationRequest $request, Location $location)
    {
        $location->name = $request->name;
        $location->branch_id = $request->branch_id;
        $location->save();

        return redirect()->to(route('location.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Location $location)
    {
        try{
            $location->delete();

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
