<?php


namespace Quattror\Swagger\Commands;

use Illuminate\Support\Facades\File;
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
            $targetDir = public_path($outputDir . '/assets');

            if (!File::isDirectory($targetDir)) {
                File::makeDirectory($targetDir, 0755, true);
            }

            $sourceDir = base_path('vendor/swagger-api/swagger-ui/dist');
            $files = [
                'swagger-ui.css',
                'swagger-ui-bundle.js',
                'swagger-ui-standalone-preset.js',
                'oauth2-redirect.html',
                'favicon-16x16.png',
                'favicon-32x32.png',
            ];

            foreach ($files as $file) {
                $source = $sourceDir . DIRECTORY_SEPARATOR . $file;
                if (!File::exists($source)) {
                    throw new \RuntimeException('Swagger UI asset not found: ' . $source);
                }
                File::copy($source, $targetDir . DIRECTORY_SEPARATOR . $file);
            }

            $customDir = __DIR__ . '/../../dist/assets';
            foreach (File::files($customDir) as $file) {
                if (substr($file->getFilename(), -4) !== '.css') {
                    continue;
                }
                File::copy($file->getPathname(), $targetDir . DIRECTORY_SEPARATOR . $file->getFilename());
            }

            $this->info('Assets copied');

        } catch (\Exception $e) {
            $this->error('An error ocurred during assets copy: ' . $e);
        }
    }
}
