<?php

namespace App\Adapters;

use App\DTOs\PrecoNormalizadoDTO;

class PrecoNormalizadoAdapter
{
    public static function toPrecoInsercaoArray(PrecoNormalizadoDTO $dto): array
    {
        return [
            'prod_cod' => $dto->codigo_produto,
            'preco_valor' => $dto->valor,
            'preco_moeda' => $dto->moeda,
            'preco_desconto_percentual' => $dto->percentual_desconto,
            'preco_acrescimo_percentual' => $dto->percentual_acrescimo,
            'preco_promocional' => $dto->valor_promocional,
            'preco_data_inicio_promocao' => null,
            'preco_data_fim_promocao' => null,
            'preco_data_atualizacao' => now()->toDateString(),
            'preco_origem' => $dto->origem,
            'preco_tipo_cliente' => $dto->tipo_cliente,
            'preco_vendedor_responsavel' => $dto->vendedor,
            'preco_observacao' => $dto->observacao,
            'preco_status' => $dto->status,
            'preco_hash_origem' => md5(json_encode((array) $dto)),
        ];
    }
}
