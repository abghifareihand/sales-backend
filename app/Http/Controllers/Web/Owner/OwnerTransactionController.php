<?php

namespace App\Http\Controllers\Web\Owner;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class OwnerTransactionController extends Controller
{
    public function index(Request $request)
    {
        $transactions = Transaction::with(['sales.branch', 'outlet', 'items.product'])
                            ->orderBy('created_at', 'desc')
                            ->get();

        return view('pages.owner.transaction.index', compact('transactions'));
    }

    public function show(Transaction $transaction)
    {
        // load relasi yang dibutuhkan
        $transaction->load('sales.branch', 'outlet', 'items.product', 'edits.approvedBy');

        return view('pages.owner.transaction.show', compact('transaction'));
    }
}
