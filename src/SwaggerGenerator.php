<?php

namespace Ntgnn\Swagger;

use File;
use OpenApi\Annotations\OpenApi;

class SwaggerGenerator
{
    /**
     * @var string
     */
    protected $outputDir;

    /**
     * @var string
     */
    protected $jsonFile;

    /**
     * @var array
     */
    protected $constants;

    /**
     * @var string|array
     */
    protected $annotationsDir;

    /**
     * @var array
     */
    protected $excludedDirs;

    /**
     * @var string
     */
    protected $swaggerBase;

    /**
     * @var OpenApi
     */
    protected $swagger;

    public function __construct()
    {
        $this->outputDir = config('swagger.generator.output_dir');
        $this->jsonFile = config('swagger.generator.json_file');
        $this->constants = config('swagger.generator.constants') ? : [];
        $this->annotationsDir = config('swagger.generator.annotations_dir');
        $this->excludedDirs = config('swagger.generator.excluded_dirs') ? : [];
        $this->swaggerBase = config('swagger.generator.swagger_base');
    }

    public static function generateDocs($overrides = [])
    {
        (new static)->prepareDirectory()
            ->defineConstants($overrides)
            ->scanFilesForDocumentation()
            ->populateServers()
            ->saveJson();
    }

    /**
     * @return SwaggerGenerator
     *
     * @throws \Exception
     */
    protected function prepareDirectory()
    {
        $path = 'public/' . $this->outputDir;

        if (!File::exists($path)) {
           File::makeDirectory($path);

        } else {
            if (!is_writable($path)){
                throw new \Exception('Output directory is not writable');
            }
        }

        return $this;
    }

    /**
     * Define constant which will be replaced.
     *
     * @return SwaggerGenerator
     */
    protected function defineConstants($overrides)
    {
        if (!empty($this->constants)) {
            $constants = array_replace($this->constants, $overrides);
            foreach ($constants as $key => $value) {
                defined($key) || define($key, $value);
            }
        }

        return $this;
    }

    /**
     * Scan directory and create Swagger.
     *
     * @return SwaggerGenerator
     */
    protected function scanFilesForDocumentation()
    {
        $this->swagger = \OpenApi\scan(
            $this->annotationsDir,
            ['exclude' => $this->excludedDirs]
        );

        return $this;
    }

    /**
     * Generate servers section or basePath depending on Swagger version.
     *
     * @return SwaggerGenerator
     */
    protected function populateServers()
    {
        if ($this->swaggerBase !== null) {
            $this->swagger->servers = [
                new \OpenApi\Annotations\Server(['url' => $this->swaggerBase]),
            ];
        }

        return $this;
    }

    /**
     * Save documentation as json file.
     *
     * @return SwaggerGenerator
     * @throws \Exception
     */
    protected function saveJson()
    {
        $filePath = 'public/' . $this->outputDir . '/' . $this->jsonFile;
        $this->swagger->saveAs($filePath);

        return $this;
    }
}
