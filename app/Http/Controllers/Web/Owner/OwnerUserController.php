<?php

namespace App\Http\Controllers\Web\Owner;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class OwnerUserController extends Controller
{
    // ===== USER PUSAT =====
    public function indexPusat()
    {
        $pusat = User::where('role', 'pusat')
                    ->orderBy('name', 'asc')
                    ->paginate(10);

        return view('pages.owner.user.pusat.index', compact('pusat'));
    }

    public function createPusat()
    {
        return view('pages.owner.user.pusat.create');
    }

    public function storePusat(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|string|min:6',
        ], [
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan, silakan pilih yang lain.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 'pusat',
            'branch_id' => null,
        ]);

        return redirect()->route('owner.user.pusat.index')
                         ->with('success', 'User akun pusat berhasil ditambahkan');
    }

    public function editPusat(User $user)
    {
        return view('pages.owner.user.pusat.edit', compact('user'));
    }

    public function updatePusat(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'password' => 'nullable|string|min:6',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan, silakan pilih yang lain.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        $user->name = $request->name;
        $user->username = $request->username;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('owner.user.pusat.index')
                        ->with('success', 'User akun pusat berhasil diperbarui');
    }


    public function destroyPusat(User $user)
    {
        $user->delete();

        return redirect()->route('owner.user.pusat.index')
                         ->with('success', 'User akun pusat berhasil dihapus');
    }

    // ===== USER CABANG =====
    public function indexCabang()
    {
        $cabang = User::where('role', 'cabang')
                    ->join('branches', 'users.branch_id', '=', 'branches.id')
                    ->select('users.*', 'branches.name as branch_name')
                    ->orderBy('branches.name', 'asc')
                    ->orderBy('users.name', 'asc')
                    ->paginate(10);

        return view('pages.owner.user.cabang.index', compact('cabang'));
    }

    public function createCabang()
    {
        $branches = Branch::all();
        return view('pages.owner.user.cabang.create', compact('branches'));
    }

    public function storeCabang(Request $request)
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

        return redirect()->route('owner.user.cabang.index')
            ->with('success', 'User akun cabang berhasil dibuat');
    }

    public function editCabang(User $user)
    {
        $branches = Branch::all();
        return view('pages.owner.user.cabang.edit', compact('user', 'branches'));
    }

    public function updateCabang(Request $request, User $user)
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

        return redirect()->route('owner.user.cabang.index')
            ->with('success', 'User akun cabang berhasil diperbarui');
    }

    public function destroyCabang(User $user)
    {
        $user->delete(); // Hapus user cabang
        return redirect()->route('owner.user.cabang.index')
                        ->with('success', 'User akun cabang berhasil dihapus');
    }


    // ===== USER SALES =====
    public function indexSales()
    {
        $sales = User::where('role', 'sales')
                    ->join('branches', 'users.branch_id', '=', 'branches.id')
                    ->select('users.*', 'branches.name as branch_name')
                    ->orderBy('branches.name', 'asc')
                    ->orderBy('users.name', 'asc')
                    ->paginate(10);

        return view('pages.owner.user.sales.index', compact('sales'));
    }

    public function createSales()
    {
        $branches = Branch::all();
        return view('pages.owner.user.sales.create', compact('branches'));
    }

    public function storeSales(Request $request)
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
            'role' => 'sales',
        ]);

        return redirect()->route('owner.user.sales.index')
            ->with('success', 'User akun sales berhasil dibuat');
    }

    public function editSales(User $user)
    {
        $branches = Branch::all();
        return view('pages.owner.user.sales.edit', compact('user', 'branches'));
    }

    public function updateSales(Request $request, User $user)
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

        return redirect()->route('owner.user.sales.index')
            ->with('success', 'User akun sales berhasil diperbarui');
    }

    public function destroySales(User $user)
    {
        $user->delete(); // Hapus user sales
        return redirect()->route('owner.user.sales.index')
                        ->with('success', 'User akun sales berhasil dihapus');
    }

}
