<?php

//Route::get(config('swagger.controller.docs_route', '/docs'), function() {
//    return 'Acerto miseravi 2';
//});

use Illuminate\Support\Facades\Route;

Route::get(config('swagger.controller.docs_route', '/docs'),    ['uses' => 'Quattror\Swagger\Http\Controllers\DocsController@index']);
