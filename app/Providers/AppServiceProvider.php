<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * @var  string
     */
    
    protected $controller = '';
    
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        app('view')->composer('layouts.master', function ($view) {
            $action     = app('request')->route()->getAction();
            if ( isset($action['controller']) )
              {
                $controller                = class_basename($action['controller']);
                list($controller, $action) = explode('@', $controller);

                if ( $controller && $action )
                  {
                    $this->controller = $controller;
                    $view->with(compact('controller', 'action')); 
                  } 
              }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
