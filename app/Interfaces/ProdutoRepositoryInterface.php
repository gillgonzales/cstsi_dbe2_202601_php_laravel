<?php

namespace App\Interfaces;

use App\Models\Produto;
use Illuminate\Database\Eloquent\Collection;

interface ProdutoRepositoryInterface {
    public function all(): ?Collection;
    public function findById(int $id): ?Produto;
    public function create(array $data): ?Produto;
}
