<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        return view('pages.auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();

            return redirect()->intended('/');
        }

        return redirect()->back()->withErrors([
            'email' => 'Email dan password tidak cocok'
        ])->onlyInput('email');
    }

    public function change_password()
    {
        $user = auth()->user();

        return view('pages.user.change_password', compact('user'));
    }

    public function do_change_password(Request $request)
    {
        $validated = $request->validate([
            'old_password' => 'required',
            'password' => 'required|confirmed|min:8',
            'password_confirmation' => 'required'
        ]);

        if(Hash::check($validated['old_password'], auth()->user()->password)){

            User::where('id', auth()->user()->id)->update([
                'password' => bcrypt($validated['password'])
            ]);

            Auth::logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return redirect()->to('login')->withSuccess([
                'status' => 'success',
                'message' => 'Berhasil ganti password, silahkan login kembali'
            ]);
        }

        return redirect()->back()->withInput()->withSuccess([
            'status' => 'danger',
            'message' => 'Old Password salah'
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
