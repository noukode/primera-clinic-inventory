<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Throwable;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = 'User List';
        $users = User::with('role');

        if($request->search){
            $users = $users->where(function($query)use($request){
                return $query->where('name', 'LIKE', '%' . $request->search . '%')->orWhere('email', 'LIKE', '%' . $request->search . '%')->orWhere(function($query)use($request){
                    return $query->whereHas("role", function($query)use($request){
                        return $query->where('name', 'LIKE', '%'. $request->search .'%');
                    });
                });
            });
        }

        $users = $users->paginate(15);

        return view('pages.user.index', compact('title', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Create User';
        $roles = UserRole::get();
        return view('pages.user.create', compact('title', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email:rfc,dns|unique:users,email',
            'role_id' => 'required|integer|exists:user_roles,id'
        ]);

        $validated['password'] = bcrypt('password');
        User::create($validated);

        return redirect()->to('user')->withSuccess([
            'status' => 'success',
            'message' => 'Berhasil tambah user',
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $title = 'User Detail';
        $roles = UserRole::get();
        return view('pages.user.show', compact('user', 'roles'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $title = 'Edit User';
        $roles = UserRole::get();
        return view('pages.user.edit', compact('title', 'user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email:rfc,dns|unique:users,email,' . $user->id,
            'role_id' => 'required|integer|exists:user_roles,id',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role_id;
        $user->save();

        return redirect()->to('user')->withSuccess([
            'status' => 'success',
            'message' => 'Berhasil update user',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try{
            $user->delete();

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
