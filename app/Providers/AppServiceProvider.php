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

        View::composer('layout.partials.header', function ($view) {
            $returnItems = Distribution::with(['product', 'fromBranch', 'toBranch', 'toSales'])
                ->whereIn('type', ['cabang_to_pusat', 'sales_to_cabang'])
                ->orderByDesc('created_at')
                ->get();

            $returnCount = $returnItems->where('is_read', false)->count();

            $view->with([
                'returnItems' => $returnItems,
                'returnCount' => $returnCount,
            ]);
        });

    }
}
