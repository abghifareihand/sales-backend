<?php

namespace App\Http\Controllers\Web\Owner;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;

class OwnerBranchController extends Controller
{
    public function index()
    {
        $branches = Branch::orderBy('id', 'desc')->get();
        return view('pages.owner.branch.index', compact('branches'));
    }

    public function create()
    {
        return view('pages.owner.branch.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'address' => 'nullable|string|max:255',
        ]);

        Branch::create($request->only(['name', 'address']));

        return redirect()->route('owner.branch.index')
            ->with('success', 'Cabang berhasil ditambahkan');
    }

    public function show(Branch $branch)
    {
        // Ambil sales dengan pagination
        $sales = $branch->users()
                        ->where('role', 'sales')
                        ->get();

        return view('pages.owner.branch.show', compact('branch', 'sales'));
    }

    public function edit(Branch $branch)
    {
        return view('pages.owner.branch.edit', compact('branch'));
    }

    public function update(Request $request, Branch $branch)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'address' => 'nullable|string|max:255',
        ]);

        $branch->update($request->only(['name', 'address']));

        return redirect()->route('owner.branch.index')
            ->with('success', 'Cabang berhasil diperbarui');
    }

    public function destroy(Branch $branch)
    {
        $branch->delete();

        return redirect()->route('owner.branch.index')
            ->with('success', 'Cabang berhasil dihapus');
    }
}
