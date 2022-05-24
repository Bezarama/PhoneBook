<?php

use App\Http\Controllers\Api\V1\ContactsApiController;
use App\Http\Controllers\Api\V1\TokenApiController;
use Illuminate\Support\Facades\Route;

Route::post('token', [TokenApiController::class, 'getToken']);

Route::apiResource('contacts', ContactsApiController::class)->middleware(['auth:sanctum']);

