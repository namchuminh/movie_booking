<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use App\Models\Cinema;
use Illuminate\Support\Facades\View;

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
        Carbon::setLocale('vi');
        
        View::composer('web.layouts.*', function ($view) {
            $cinemas   = Cinema::select('id','name','province','location','image', 'type')->orderBy('name')->get();
            $provinces = Cinema::query()->select('province')->distinct()->orderBy('province')->pluck('province');
            $view->with(compact('cinemas','provinces'));
        });
    }
}
