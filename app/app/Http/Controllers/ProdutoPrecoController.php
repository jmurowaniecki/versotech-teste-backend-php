<?php
namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

use App\Models\ProdutoInsercao;

class ProdutoPrecoController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 15);

        $query = ProdutoInsercao::query()
            ->with('preco')
            ->orderBy('prod_cod');

        return response()->json(
            $query->paginate($perPage)
        );
    }
}
