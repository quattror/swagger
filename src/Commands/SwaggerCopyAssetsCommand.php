<?php


namespace Ntgnn\Swagger\Commands;

use File;
use Illuminate\Console\Command;

class SwaggerCopyAssetsCommand extends Command
{
    protected $name = 'swagger:copy-assets';
    protected $description = 'Copies the assets folder to the public folder';

    public function handle()
    {
        try
        {
            //Test if swagger config file is present
            if (!File::exists(config_path('swagger.php'))) {
                $this->error('Swagger configuration file not found. Run swagger:init first');
                return;
            }

            $outputDir = config('swagger.generator.output_dir');

            //Copy swagger assets folder
            $assetPath = __DIR__.'/../../dist/assets';
            File::copyDirectory($assetPath, public_path('/' . $outputDir . '/assets'));

            $this->info('Assets copied');

        } catch (\Exception $e) {
            $this->error('An error ocurred during assets copy: ' . $e);
        }
    }
}
