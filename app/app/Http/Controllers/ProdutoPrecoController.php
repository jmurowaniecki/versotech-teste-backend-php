<?php
namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

use App\Models\ProdutoInsercao;


class ProdutoPrecoController extends Controller
{
    #[OA\Get(
        path: "/api/produtos-precos",
        summary: "Deve retornar os produtos processados com seus respectivos preços de forma paginada. A paginação deve aceitar parâmetros de controle via query string.",
        responses: [
            new OA\Response(response: 200, description: "Success")
        ]
    )]
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 15);

        $query = ProdutoInsercao::query()
            ->with('precos')
            ->orderBy('prod_cod');

        return response()->json(
            $query->paginate($perPage)
        );
    }
}
