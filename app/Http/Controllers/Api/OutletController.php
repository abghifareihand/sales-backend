<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Outlet;
use Illuminate\Http\Request;

class OutletController extends Controller
{
    // Ambil outlet hanya yang dibuat oleh user login
    public function index(Request $request)
    {
        $user = $request->user(); // user yang login

        $outlets = Outlet::where('created_by', $user->id)->get();

        return response()->json([
            'status' => true,
            'message' => 'Daftar outlet berhasil didapatkan',
            'outlets' => $outlets
        ]);
    }

    // Simpan outlet baru dengan created_by = user login
    public function store(Request $request)
    {
        $request->validate([
            'id_outlet' => 'required|string',
            'name_outlet' => 'required|string',
            'address_outlet' => 'required|string',
            'name' => 'nullable|string',
            'phone' => 'nullable|string',
            'latitude' => 'required|string',
            'longitude' => 'required|string'
        ]);

        $user = $request->user();

        $outlet = Outlet::create([
            'id_outlet' => $request->id_outlet,
            'name_outlet' => $request->name_outlet,
            'address_outlet' => $request->address_outlet,
            'name' => $request->name,
            'phone' => $request->phone,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'created_by' => $user->id
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Outlet baru berhasil dibuat',
            'outlet' => $outlet
        ]);
    }
}
