<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

use App\Services\ProdutoPrecoSyncService;

#[Signature('sync {type : all|precos|produtos|…}')]
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
        $option = strtolower($this->argument('type'));
        $handle = $this->handlers();

        if (!isset($handle[$option])) {
            return $this->invalidType(array_keys($handle));
        }
        $method = $handle[$option];

        return $this->$method();
    }

    public function getSynopsis(bool $short = false): string
    {
        $types = array_keys($this->handlers());

        return sprintf(
            "sync:run {%s}",
            implode('|', $types)
        );
    }
    public function getHelp(): string
    {
        $lines = array_map(
            fn ($t) => " - {$t}",
            array_keys($this->handlers())
        );

        return "Tipos disponíveis:\n" . implode("\n", $lines);
    }

    public function getDescription(): string
    {
        $types = implode('|', array_keys($this->handlers()));

        return "Executa sincronização ({$types})";
    }

    private function handlers(): array
    {
        $methods = (new \ReflectionClass($this))->getMethods(\ReflectionMethod::IS_PUBLIC);

        return collect($methods)
            ->filter(fn ($m) =>
                str_starts_with($m->name, 'run')
                && $m->class === static::class
            )
            ->mapWithKeys(fn ($m) => [
                strtolower(substr($m->name, 3)) => $m->name
            ])
            ->toArray();
    }

    private function invalidType(array $valid): int
    {
        $this->error('Tipo inválido.');
        $this->line('Tipos válidos:');
        foreach ($valid as $type) {
            $this->line(" - {$type}");
        }

        return self::FAILURE;
    }

    /**
     * Wrappers para uso via comando Artisan.
     */
    public function runProdutos(): int
    {
        $this->service->syncProdutos();
        $this->info('Produtos sincronizados com sucesso.');
        return self::SUCCESS;
    }

    public function runPrecos(): int
    {
        $this->service->syncPrecos();
        $this->info('Preços sincronizados com sucesso.');
        return self::SUCCESS;
    }

    public function runAll(): int
    {
        $this->service->syncAll();
        $this->info('Sincronização completa executada.');
        return self::SUCCESS;
    }
}
