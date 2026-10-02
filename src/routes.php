<?php

use Illuminate\Support\Facades\Route;
use Quattror\Swagger\Http\Controllers\DocsController;

Route::get(
    config('swagger.controller.docs_route', '/docs'),
    [DocsController::class, 'index']
);
