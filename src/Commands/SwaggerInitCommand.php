<?php

namespace Quattror\Swagger\Commands;

use File;
use Illuminate\Console\Command;
use Quattror\Swagger\SwaggerServiceProvider;

class SwaggerInitCommand extends Command
{
    protected $name = 'swagger:init';
    protected $description = 'Initializes the Swagger structure';

    public function handle()
    {
        try
        {
            //Copy swagger main config file
            $configPath = __DIR__.'/../../config/swagger.php';
            File::copy($configPath, config_path('swagger.php'));

            //Copy swagger base structure
            $basePath = __DIR__.'/../Http/Swagger';
            File::copyDirectory($basePath, app_path('/Http/Swagger'));

            $this->info('Swagger initialized');

        } catch (\Exception $e) {
            $this->error('An error ocurred during swagger initialization: ' . $e);
        }
    }
}
