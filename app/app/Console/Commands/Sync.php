<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

use App\Services\ProdutoPrecoSyncService;

#[Signature('sync {type : ambos|precos|produtos}')]
#[Description('Sincroniza produtos da view normalizada preços, produtos ou ambos.')]
class Sync extends Command
{
    public function __construct(
        private ProdutoPrecoSyncService $service
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        return match ($this->argument('type')) {
            'produtos' => $this->runProdutos(),
            'precos'   => $this->runPrecos(),
            'ambos'    => $this->runAll(),
            default    => self::invalidType(),
        };
    }

    /**
     * Wrappers para uso via comando Artisan.
     */
    private function runProdutos(): int
    {
        $this->service->syncProdutos();
        $this->info('Produtos sincronizados com sucesso.');
        return self::SUCCESS;
    }

    private function runPrecos(): int
    {
        $this->service->syncPrecos();
        $this->info('Preços sincronizados com sucesso.');
        return self::SUCCESS;
    }

    private function runAll(): int
    {
        $this->service->syncAll();
        $this->info('Sincronização completa executada.');
        return self::SUCCESS;
    }
}
