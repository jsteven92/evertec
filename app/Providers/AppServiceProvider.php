<?php

namespace App\Providers;

use App\Services\Interfaces\IOrderService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Services\Interfaces\IstoreServices;
use App\Services\OrderService;
use App\Services\storeServices;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IstoreServices::class, storeServices::class);
        $this->app->bind(IOrderService::class, OrderService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }
}
