<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Distribution;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function markRead()
    {
        Distribution::where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json(['status' => true]);
    }
}
