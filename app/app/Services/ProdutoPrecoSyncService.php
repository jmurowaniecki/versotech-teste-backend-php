<?php

namespace App\Services;

use App\Models\ProdutoInsercao;
use App\Models\PrecoInsercao;
use App\Models\VwProdutoNormalizado;
use App\Models\VwPrecoNormalizado;
use App\DTOs\ProdutoNormalizadoDTO;
use App\DTOs\PrecoNormalizadoDTO;
use App\Adapters\ProdutoNormalizadoAdapter;
use App\Adapters\PrecoNormalizadoAdapter;
use Illuminate\Support\Facades\DB;

class ProdutoPrecoSyncService
{
    /**
     * Processa e sincroniza todos os produtos e preços normalizados para as tabelas de inserção.
     */
    public function syncAll(): int
    {
        $updateds = 0;
        DB::transaction(function () use ($updateds) {
            $updateds += $this->syncProdutos();
            $updateds += $this->syncPrecos();
        });
        return $updateds;
    }

    /**
     * Sincroniza produtos da view normalizada para inserção.
     */
    public function syncProdutos(): int
    {
        $updateds = 0;
        $produtos = VwProdutoNormalizado::all();
        foreach ($produtos as $produtoModel) {
            $from = ProdutoNormalizadoDTO::fromArray($produtoModel->toArray());
            $data = ProdutoNormalizadoAdapter::toProdutoInsercaoArray($from);

            ProdutoInsercao::updateOrCreate(
                ['prod_cod' => $data['prod_cod']],
                $data
            ) && $updateds++;
        }
        return $updateds;
    }

    /**
     * Sincroniza preços da view normalizada para inserção.
     */
    public function syncPrecos(): int
    {
        $updateds = 0;
        $osprecos = VwPrecoNormalizado::all();
        foreach ($osprecos as $precoModel) {
            $from = PrecoNormalizadoDTO::fromArray($precoModel->toArray());
            $data = PrecoNormalizadoAdapter::toPrecoInsercaoArray($from);

            // uasr prod_cod + data de atualização para deduplicação
            $key = [
                'prod_cod' => $data['prod_cod'],
                'preco_data_atualizacao' => $data['preco_data_atualizacao'] ?? now()->toDateString(),
            ];

            PrecoInsercao::updateOrCreate(
                $key,
                $data
            ) && $updateds++;
        }
        return $updateds;
    }
}
