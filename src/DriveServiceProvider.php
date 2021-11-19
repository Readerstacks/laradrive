<?php

namespace Readerstacks\Drive;

use Illuminate\Support\ServiceProvider;
 
class DriveServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
         
      
        // $this->publishes([
        //     __DIR__.'/cms_config.php' => config_path('cms_config.php','cmsconfig'),
        // ]);
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        // $this->loadMigrationsFrom(__DIR__.'/migrations');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'Drive');
        // $this->publishes([
        //     __DIR__.'/views' => base_path('resources/views/aman'),
        // ]);
    
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // $this->mergeConfigFrom(
        //     __DIR__.'/cms_config.php' ,'cmsconfig'
        // );
        //   $this->app->make('Aman\SeoManagaer\Controllers\CrudController');
    }
}
