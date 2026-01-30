<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\LibraryFunctionController as LFC;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();
        // Share isSuperadmin with all admin views
        View::composer('admin-page.*', function ($view) {
            if (auth()->check()) {
                $isSuperadmin = LFC::getRoleName(auth()->user()->getRoleNames()) === 'Superadmin';
                $view->with('isSuperadmin', $isSuperadmin);
            } else {
                $view->with('isSuperadmin', false);
            }
        });

        // Share isSuperadmin with components
        View::composer('components.admin-index.*', function ($view) {
            if (auth()->check()) {
                $isSuperadmin = LFC::getRoleName(auth()->user()->getRoleNames()) === 'Superadmin';
                $view->with('isSuperadmin', $isSuperadmin);
            } else {
                $view->with('isSuperadmin', false);
            }
        });
    }
}
