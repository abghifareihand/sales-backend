<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Stock;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $salesId = $request->user()->id;

        $today = Transaction::where('sales_id',$salesId)->whereDate('created_at',Carbon::today())->sum('total');
        $yesterday = Transaction::where('sales_id',$salesId)->whereDate('created_at',Carbon::yesterday())->sum('total');

        $weekStart = Carbon::now()->startOfWeek();
        $lastWeekStart = Carbon::now()->subWeek()->startOfWeek();
        $weekSales = Transaction::where('sales_id',$salesId)->whereBetween('created_at',[$weekStart,Carbon::now()])->sum('total');
        $lastWeekSales = Transaction::where('sales_id',$salesId)->whereBetween('created_at',[$lastWeekStart,$weekStart->copy()->subSecond()])->sum('total');

        $monthSales = Transaction::where('sales_id',$salesId)->whereMonth('created_at',Carbon::now()->month)->sum('total');
        $lastMonthSales = Transaction::where('sales_id',$salesId)->whereMonth('created_at',Carbon::now()->subMonth()->month)->sum('total');

        // Stok cabang tempat sales berada
        $branchId = $request->user()->branch_id;
        $stocks = Stock::where('branch_id',$branchId)->with('product')->get();

        return response()->json([
            'today'=>$today,
            'yesterday'=>$yesterday,
            'week'=>$weekSales,
            'last_week'=>$lastWeekSales,
            'month'=>$monthSales,
            'last_month'=>$lastMonthSales,
            'stocks'=>$stocks
        ]);
    }

    public function distributions(Request $request){
        $salesId = $request->user()->id;
        $distributions = $request->user()->distributionsReceived()->with('product','fromBranch')->get();
        return response()->json($distributions);
    }
}
