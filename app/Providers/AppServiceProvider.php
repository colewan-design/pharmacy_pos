<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use DB;
use Log;
use File;
use Illuminate\Support\Facades\{Auth};

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
        DB::listen(function($query) {
            File::append(
                storage_path('/logs/dev_query'.date('Y-m-d').'.log'),
                '[' . date('Y-m-d H:i:s') . ']'. "Invoker:"
                 . PHP_EOL . $query->sql . ' [' . implode(', ', $query->bindings)  . ']' . " ~ TIME:" . $query->time . "ms". PHP_EOL . PHP_EOL
            );
        });
    }
}
