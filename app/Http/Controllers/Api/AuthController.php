<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('username', $request->username)
                    ->where('role', 'sales') // wajib role sales
                    ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Username atau password salah'
            ], 401);
        }

        $token = $user->createToken('sales_token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Login berhasil',
            'user' => $user,
            'token' => $token
        ]);
    }

    public function logout(Request $request)
    {
        // ✅ Hapus token yang sedang dipakai (current device)
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => true,
            'message' => 'Logout berhasil'
        ]);
    }

    public function profile(Request $request)
    {
        $user = $request->user()->load('branch');

        return response()->json([
            'status' => true,
            'message' => 'Data profil berhasil diambil',
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'name' => $user->name,
                'role' => $user->role,
                'branch_id' => $user->branch->id,
                'branch_name' => $user->branch->name,
                'branch_address' => $user->branch->address,
            ]
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();

        // Validasi: name & username wajib, sisanya opsional
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
        ]);

        // Update user
        $user->update($validated);

        return response()->json([
            'status'  => true,
            'message' => 'Profil berhasil diperbarui',
            'user'    => $user
        ], 200);
    }

    public function updatePassword(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'current_password'      => 'required|string',
            'new_password'          => 'required|string|min:6|confirmed',
            // otomatis butuh field "new_password_confirmation"
        ]);

        // ✅ Cek apakah current_password benar
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Password saat ini salah'
            ], 400);
        }

        // ✅ Update password
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Password berhasil diperbarui'
        ], 200);
    }
}
