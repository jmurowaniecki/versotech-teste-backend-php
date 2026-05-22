<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use OpenApi\Attributes as OA;

#[OA\Info(
    version: "1.0.0",
    description: "Aplicação backend responsável pelo processamento, transformação e sincronização de dados de produtos e preços, utilizando Views SQL para padronização das informações e disponibilizando os dados por meio de uma API REST.",
    title: "Versottech - Teste Backend PHP"
)]
#[OA\Tag(name: "Gerenciamento", description: "Endpoints gerenciamento do serviços, execução de testes, …")]
#[OA\Tag(name: "Sincronização", description: "Endpoints para sincronização de Preços, Produtos, …")]

class API extends BaseController
{

    #[OA\Get(
        path: "/api/test",
        summary: "Healthcheck",
        tags: ["Gerenciamento"],
        responses: [
            new OA\Response(response: 200, description: "Success")
        ]
    )]
    public function testEndpoint()
    {
        return response()->json(['message' => 'Swagger is working!']);
    }

    #[OA\Get(
        path: "/api/csrf_token",
        summary: "Retorna CSRF Token da sessão atual.",
        tags: ["Gerenciamento"],
        responses: [
            new OA\Response(response: 200, description: "Success")
        ]
    )]
    public function csrfToken()
    {
        return response()->json(['token' => csrf_token()]);
    }
}
