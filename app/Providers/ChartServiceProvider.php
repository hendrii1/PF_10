<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ChartServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('App\Charts\EmployeesChart', 'App\Charts\EmployeesChart');
    }

    public function boot()
    {
        //
    }
}
