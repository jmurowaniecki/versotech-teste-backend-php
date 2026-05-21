<?php

namespace App\DTOs;

class PrecoNormalizadoDTO
{
    public function __construct(
        public int $preco_id,
        public string $codigo_produto,
        public ?float $valor,
        public string $moeda,
        public ?float $percentual_desconto,
        public ?float $percentual_acrescimo,
        public ?float $valor_promocional,
        public string $tipo_cliente,
        public string $vendedor,
        public string $origem,
        public ?string $observacao,
        public string $status,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['preco_id'],
            $data['codigo_produto'],
            isset($data['valor']) ? (float) $data['valor'] : null,
            $data['moeda'],
            isset($data['percentual_desconto']) ? (float) $data['percentual_desconto'] : null,
            isset($data['percentual_acrescimo']) ? (float) $data['percentual_acrescimo'] : null,
            isset($data['valor_promocional']) ? (float) $data['valor_promocional'] : null,
            $data['tipo_cliente'],
            $data['vendedor'],
            $data['origem'],
            $data['observacao'] ?? null,
            $data['status'],
        );
    }
}
