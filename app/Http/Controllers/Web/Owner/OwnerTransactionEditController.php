<?php

namespace App\Http\Controllers\Web\Owner;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\TransactionEdit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OwnerTransactionEditController extends Controller
{
    public function index(Request $request)
    {
        $transactions = Transaction::with(['sales', 'branch', 'outlet', 'items.product', 'edits.submittedBy'])
            ->whereHas('edits', function($q) {
                $q->where('status', 'pending'); // hanya yang pending
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.owner.transaction-edit.index', compact('transactions'));
    }


    public function show(Transaction $transaction)
    {
        $transaction->load(['sales', 'branch', 'outlet', 'items.product', 'edits.submittedBy']);

        return view('pages.owner.transaction-edit.show', compact('transaction'));
    }


    // Approve pengajuan edit
    public function approveEdit(TransactionEdit $edit)
    {
        $edit->status = 'approved';
        $edit->approved_by = Auth::id(); // user owner yang approve
        $edit->save();

        // Update total transaksi dan profit jika disetujui
        $transaction = $edit->transaction;
        $transaction->total = $edit->edit_total;

        // Hitung ulang profit: total baru - total HPP semua item
        $costTotal = $transaction->items->sum(fn($item) => $item->cost_price * $item->quantity);
        $transaction->profit = $transaction->total - $costTotal;

        $transaction->save();

        return redirect()->back()->with('success', 'Pengajuan berhasil disetujui');
    }



    // Reject pengajuan edit
    public function rejectEdit(TransactionEdit $edit)
    {
        $edit->status = 'rejected';
        $edit->approved_by = Auth::id();
        $edit->save();

        return redirect()->back()->with('success', 'Pengajuan berhasil ditolak');
    }
}
