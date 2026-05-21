<?php

namespace App\DTOs;

class ProdutoNormalizadoDTO
{
    public function __construct(
        public int $prod_id,
        public string $codigo,
        public string $nome,
        public string $categoria,
        public string $subcategoria,
        public string $descricao,
        public string $fabricante,
        public string $modelo,
        public string $cor,
        public ?float $peso_gramas,
        public ?string $unidade,
        public ?float $largura_cm,
        public ?float $altura_cm,
        public ?float $profundidade_cm,
        public ?string $data_cadastro,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['prod_id'],
            $data['codigo'],
            $data['nome'],
            $data['categoria'],
            $data['subcategoria'],
            $data['descricao'],
            $data['fabricante'],
            $data['modelo'],
            $data['cor'],
            isset($data['peso_gramas']) ? (float) $data['peso_gramas'] : null,
            $data['unidade'] ?? null,
            isset($data['largura_cm']) ? (float) $data['largura_cm'] : null,
            isset($data['altura_cm']) ? (float) $data['altura_cm'] : null,
            isset($data['profundidade_cm']) ? (float) $data['profundidade_cm'] : null,
            $data['data_cadastro'] ?? null,
        );
    }
}
