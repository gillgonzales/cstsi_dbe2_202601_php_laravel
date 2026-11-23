<?php

namespace App\Repositories;

use App\Models\Produto;
use App\Interfaces\ProdutoRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ProdutoRepository implements ProdutoRepositoryInterface
{
    public function all():Collection {
        return Produto::all();
    }

    public function findById(int $id): ?Produto
    {
       return Produto::findOrfail($id)->load('promocoes','fornecedor.estado.regiao');
    }

    public function create(array $data): Produto
    {
        if (!$data['imagem'])
            return Produto::create($data);

        $novoProduto = Produto::create($data);
        $novoProduto->medias()->create([
            'source' => $data['imagem']
        ]);
        return $novoProduto->load('links');
    }
}
