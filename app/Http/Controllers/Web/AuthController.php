<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        return view('pages.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('username', $request->username)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);

            // redirect per role
            switch($user->role) {
                case 'pusat':
                    return redirect()->route('pusat.dashboard.index');
                case 'cabang':
                    return redirect()->route('cabang.dashboard.index');
                case 'owner':
                    return redirect()->route('owner.dashboard.index');
                default:
                    return redirect('/');
            }
        }

        // 5️⃣ Kembalikan ke login dengan pesan error
        return back()->withInput($request->only('username')) // tetap isi username
                     ->with('error', 'Username atau password salah.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
