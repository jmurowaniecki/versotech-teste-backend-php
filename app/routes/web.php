<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API;

use App\Http\Controllers\ProdutoPrecoController;
use App\Http\Controllers\SincronizacaoController;

Route::get('/api/test', [API::class, 'testEndpoint']);

Route::prefix('api/sincronizar')->group(function () {
    Route::post('/produtos', [SincronizacaoController::class, 'produtos']);
    Route::post('/precos', [SincronizacaoController::class, 'precos']);
});

Route::get('/api/produtos-precos', [ProdutoPrecoController::class, 'index']);
