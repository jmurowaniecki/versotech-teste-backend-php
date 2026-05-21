<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API;

Route::get('/api/test', [API::class, 'testEndpoint']);
