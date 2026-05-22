<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use OpenApi\Attributes as OA;

use App\Services\ProdutoPrecoSyncService;

class SincronizacaoController extends Controller
{
    public function __construct(
        private ProdutoPrecoSyncService $service
    ) {}


    #[OA\Post(
        path: "/api/sincronizar/produtos",
        summary: "Executa o processo de transformação e sincronização dos dados de `produtos_base` para `produto_insercao`.",
        responses: [
            new OA\Response(response: 200, description: "Success")
        ]
    )]
    public function produtos()
    {
        $this->service->syncProdutos();

        return response()->json([
            'message' => 'Produtos sincronizados com sucesso'
        ]);
    }

    #[OA\Post(
        path: "/api/sincronizar/precos",
        summary: "Executa o processo de transformação e sincronização dos dados de `precos_base` para `preco_insercao`.",
        responses: [
            new OA\Response(response: 200, description: "Success")
        ]
    )]
    public function precos()
    {
        $this->service->syncPrecos();

        return response()->json([
            'message' => 'Preços sincronizados com sucesso'
        ]);
    }
}
