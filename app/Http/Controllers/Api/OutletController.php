<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Outlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'id_outlet' => 'required|string|unique:outlets,id_outlet',
            'name_outlet' => 'required|string',
            'address_outlet' => 'required|string',
            'name' => 'nullable|string',
            'phone' => 'nullable|string',
            'latitude' => 'required|string',
            'longitude' => 'required|string'
        ], [
            'id_outlet.unique' => 'ID outlet sudah digunakan'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first() // ambil error pertama dari semua field
            ], 400);
        }


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
