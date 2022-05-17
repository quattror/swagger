<?php

namespace Quattror\Swagger;

use Illuminate\Support\ServiceProvider;

class SwaggerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->commands([
            \Quattror\Swagger\Commands\SwaggerInitCommand::class,
            \Quattror\Swagger\Commands\SwaggerGenerateDocsCommand::class,
            \Quattror\Swagger\Commands\SwaggerCopyAssetsCommand::class
        ]);
    }

    public function boot()
    {
        //Include routes
        $routePath = __DIR__.'/routes.php';
        $this->loadRoutesFrom($routePath);

        //Include views
        $viewPath = __DIR__.'/../resources/views';
        $this->loadViewsFrom($viewPath, 'swagger');
    }
}
