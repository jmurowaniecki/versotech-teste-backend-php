<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API;

use App\Http\Controllers\ProdutoPrecoController;
use App\Http\Controllers\SincronizacaoController;


Route::prefix('/api')->group(function () {
    Route::get('/test', [API::class, 'testEndpoint']);
    Route::get('/csrf_token', [API::class, 'csrfToken']);
    Route::get('/produtos-precos', [ProdutoPrecoController::class, 'index']);

    Route::prefix('/sincronizar')->group(function () {
        Route::post('/produtos', [SincronizacaoController::class, 'produtos']);
        Route::post('/precos', [SincronizacaoController::class, 'precos']);
    });
});



