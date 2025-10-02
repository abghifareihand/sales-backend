<?php

namespace App\Http\Controllers\Web\Cabang;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\TransactionEdit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CabangTransactionController extends Controller
{
    // Tampilkan daftar transaksi sales cabang
    public function index(Request $request)
    {
        $branchId = Auth::user()->branch_id;

        $transactions = Transaction::whereHas('sales', function($q) use ($branchId) {
                                $q->where('branch_id', $branchId);
                            })
                            ->with('sales', 'outlet', 'items.product')
                            ->orderBy('created_at', 'desc')
                            ->get();

        return view('pages.cabang.transaction.index', compact('transactions'));
    }

    public function show(Transaction $transaction)
    {
        $branchId = Auth::user()->branch_id;

        // Pastikan transaksi berasal dari sales cabang login
        if($transaction->sales->branch_id != $branchId){
            abort(403);
        }

        $transaction->load('sales', 'outlet', 'items.product', 'edits.approvedBy');

        return view('pages.cabang.transaction.show', compact('transaction'));
    }


    public function editSubmitPrice(Transaction $transaction)
    {
        return view('pages.cabang.transaction.edit', compact('transaction'));
    }

    public function updateSubmitPrice(Request $request, Transaction $transaction)
    {
        $request->validate([
            'edit_total' => 'required|numeric|min:1',
            'edit_reason' => 'required|string|max:500',
        ], [
            'edit_total.required' => 'Total baru wajib diisi',
            'edit_total.numeric' => 'Total baru harus berupa angka',
            'edit_total.min' => 'Total minimal 1',
            'edit_reason.required' => 'Alasan perubahan harga wajib diisi',
        ]);

        // hitung HPP dari items
        $costTotal = $transaction->items->sum(function ($item) {
            return ($item->cost_price ?? 0) * ($item->quantity ?? 0);
        });

        // hitung profit estimasi
        $editProfit = $request->edit_total - $costTotal;

        // // validasi jika profit <= 0
        // if ($editProfit <= 0) {
        //     return redirect()->back()->with('error', 'Pengajuan gagal: profit tidak boleh 0 atau minus.');
        // }

        TransactionEdit::create([
            'transaction_id' => $transaction->id,
            'old_total'      => $transaction->total,
            'old_profit'     => $transaction->profit,
            'edit_total'     => $request->edit_total,
            'edit_profit'    => $editProfit,
            'edit_reason'    => $request->edit_reason,
            'submitted_by'   => Auth::id(),
            'status'         => 'pending',
        ]);

        return redirect()->route('cabang.transaction.index')->with('success', 'Pengajuan perubahan total berhasil dikirim');
    }
}
