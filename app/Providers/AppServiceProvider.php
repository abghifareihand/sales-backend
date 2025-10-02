<?php

namespace App\Providers;

use App\Models\Distribution;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Carbon::setLocale('id');
        Paginator::useBootstrapFive();

        // =========================
        // Notifikasi return stok
        // =========================
        // View::composer('layout.partials.header', function ($view) {
        //     $user = Auth::user();

        //     if($user && in_array($user->role, ['owner','pusat'])) {
        //         $returnItems = Distribution::with(['product','fromBranch','toBranch','toSales'])
        //             ->where(function($q){
        //                 $q->where('type','cabang_to_pusat')
        //                 ->orWhere('type','sales_to_cabang');
        //             })
        //             ->whereDate('created_at', now())
        //             ->orderByDesc('created_at')
        //             ->get();

        //         $returnCount = $returnItems->count();

        //         $view->with(compact('returnItems','returnCount'));
        //     }
        // });
    }
}
