<?php

namespace App\Handlers;

use App\Requests\SyncRequest;
use App\Services\SyncAllService;
use App\Services\SyncPrecosService;
use App\Services\SyncProdutosService;
use InvalidArgumentException;

class SyncHandler
{
    public function __construct(
        private SyncAllService $all,
        private SyncPrecosService $precos,
        private SyncProdutosService $produtos,
    ) {}

    public function handle(SyncRequest $request): void
    {
        match ($request->type) {
            'all' => $this->all->execute(),
            'precos' => $this->precos->execute(),
            'produtos' => $this->produtos->execute(),
            default => throw new InvalidArgumentException('Tipo inválido'),
        };
    }
}
