<?php

namespace App\Providers;

use App\Services\Facades\Timezone;
use App\Services\TimezoneService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

class TimezoneServiceProvider extends ServiceProvider
{

    protected $defer = false;

    public function boot()
    {
        AliasLoader::getInstance()->alias('Timezone', Timezone::class);
    }

    public function register()
    {
        $this->app->bind('timezone', TimezoneService::class);
    }

    public function provides()
    {
        return array();
    }

}