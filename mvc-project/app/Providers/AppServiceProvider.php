<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Category;

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
        View::composer('*', function ($view) {
            $globalCategories = Category::with(['children' => function($q) {
                $q->orderBy('position', 'asc')->orderBy('name', 'asc');
            }])
            ->whereNull('parent_id')
            ->orderBy('position', 'asc')
            ->orderBy('name', 'asc')
            ->get();
            $view->with('globalCategories', $globalCategories);
        });
    }
}
