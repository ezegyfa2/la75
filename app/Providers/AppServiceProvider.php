<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Ezegyfa\LaravelHelperMethods\Language\Commands\CreateTranslateFile;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        {
            $this->commands([
                CreateTranslateFile::class
            ]);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
