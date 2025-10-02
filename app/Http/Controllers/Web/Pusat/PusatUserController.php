<?php

namespace App\Http\Controllers\Web\Pusat;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PusatUserController extends Controller
{
    public function index()
    {
        $cabang = User::where('role', 'cabang')
                    ->join('branches', 'users.branch_id', '=', 'branches.id')
                    ->select('users.*', 'branches.name as branch_name')
                    ->orderBy('branches.name', 'asc')  // urut berdasarkan nama cabang
                    ->orderBy('users.name', 'asc')     // urut dalam cabang berdasarkan nama user
                    ->get();

        return view('pages.pusat.user.index', compact('cabang'));
    }

    public function create()
    {
        $branches = Branch::all();
        return view('pages.pusat.user.create', compact('branches'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:users,username',
            'password' => 'required|string|min:6',
            'branch_id' => 'required|exists:branches,id',
        ],[
            'name.required' => 'Name tidak boleh kosong!',
            'username.required' => 'Username tidak boleh kosong!',
            'password.required' => 'Password tidak boleh kosong!',
            'password.min' => 'Password minimal 6 karakter!',
            'branch_id.required' => 'Silakan pilih cabang!',
            'branch_id.exists' => 'Cabang yang dipilih tidak valid!',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'branch_id' => $request->branch_id,
            'role' => 'cabang',
        ]);

        return redirect()->route('pusat.user.index')
            ->with('success', 'User akun cabang berhasil dibuat');
    }

    public function edit(User $user)
    {
        $branches = Branch::all();
        return view('pages.pusat.user.edit', compact('user', 'branches'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:users,username,' . $user->id,
            'password' => 'nullable|string|min:6',
            'branch_id' => 'required|exists:branches,id',
        ],[
            'name.required' => 'Name tidak boleh kosong!',
            'username.required' => 'Username tidak boleh kosong!',
            'password.min' => 'Password minimal 6 karakter!',
            'branch_id.required' => 'Silakan pilih cabang!',
            'branch_id.exists' => 'Cabang yang dipilih tidak valid!',
        ]);

        $user->name = $request->name;
        $user->username = $request->username;
        $user->branch_id = $request->branch_id;

        // Jika password diisi, update
        if($request->password){
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('pusat.user.index')
            ->with('success', 'User akun cabang berhasil diperbarui');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('pusat.user.index')
                        ->with('success', 'User akun cabang berhasil dihapus');
    }
}
