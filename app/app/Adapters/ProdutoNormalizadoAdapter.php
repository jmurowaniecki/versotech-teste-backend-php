<?php

namespace App\Adapters;

use App\DTOs\ProdutoNormalizadoDTO;

class ProdutoNormalizadoAdapter
{
    public static function toProdutoInsercaoArray(ProdutoNormalizadoDTO $dto): array
    {
        return [
            'prod_cod' => $dto->codigo,
            'prod_nome' => $dto->nome,
            'prod_categoria' => $dto->categoria,
            'prod_subcategoria' => $dto->subcategoria,
            'prod_descricao' => $dto->descricao,
            'prod_fabricante' => $dto->fabricante,
            'prod_modelo' => $dto->modelo,
            'prod_cor' => $dto->cor,
            'prod_peso' => $dto->peso_gramas,
            'prod_largura' => $dto->largura_cm,
            'prod_altura' => $dto->altura_cm,
            'prod_profundidade' => $dto->profundidade_cm,
            'prod_unidade' => $dto->unidade,
            'prod_ativo' => true,
            'prod_data_cadastro' => $dto->data_cadastro,
            'prod_hash_origem' => md5(json_encode((array) $dto)),
        ];
    }
}
