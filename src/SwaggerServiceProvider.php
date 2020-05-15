<?php

namespace Ntgnn\Swagger;

use Illuminate\Support\ServiceProvider;

class SwaggerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->commands([
            \Ntgnn\Swagger\Commands\SwaggerInitCommand::class,
            \Ntgnn\Swagger\Commands\SwaggerGenerateDocsCommand::class,
            \Ntgnn\Swagger\Commands\SwaggerCopyAssetsCommand::class
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
