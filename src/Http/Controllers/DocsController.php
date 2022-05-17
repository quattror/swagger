<?php


namespace Quattror\Swagger\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Request;
use Response;

class DocsController extends BaseController
{
    /**
     * Display Swagger API page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ($proxy = config('swagger.controller.proxy')) {
            if (! is_array($proxy)) {
                $proxy = [$proxy];
            }
            Request::setTrustedProxies($proxy, Request::HEADER_X_FORWARDED_ALL);
        }

        return Response::make(
            view('swagger::index', [
                'secure' => Request::secure(),
                'title' => config('swagger.controller.view_title'),
                'env' => config('swagger.controller.view_env'),
                'logo' => config('swagger.controller.view_logo'),
                'favicon' => config('swagger.controller.view_favicon'),
                'assetsDir' => config('swagger.generator.output_dir') . '/assets/',
                'urlToDocs' => config('swagger.generator.output_dir') . '/' . config('swagger.generator.json_file'),
            ]),
            200
        );
    }
}
