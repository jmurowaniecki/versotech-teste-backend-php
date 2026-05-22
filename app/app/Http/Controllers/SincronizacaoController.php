<?php

namespace App\Http\Controllers;

use App\Services\ProdutoPrecoSyncService;

class SincronizacaoController extends Controller
{
    public function __construct(
        private ProdutoPrecoSyncService $service
    ) {}

    public function produtos()
    {
        $this->service->syncProdutos();

        return response()->json([
            'message' => 'Produtos sincronizados com sucesso'
        ]);
    }

    public function precos()
    {
        $this->service->syncPrecos();

        return response()->json([
            'message' => 'Preços sincronizados com sucesso'
        ]);
    }
}
