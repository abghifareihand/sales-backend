<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Distribution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        // Ambil notifikasi hanya untuk tipe cabang_to_pusat dan sales_to_cabang
        $notifications = Distribution::whereIn('type', ['cabang_to_pusat', 'sales_to_cabang'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.notification.index', compact('notifications'));
    }

    public function markRead()
    {
        Distribution::where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json(['status' => true]);
    }
}
