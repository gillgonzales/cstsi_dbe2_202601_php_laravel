<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Http\Requests\ProdutoStoreRequest;
use App\Http\Requests\ProdutoUpdateRequest;
use App\Http\Resources\ProdutoResource;
use App\Http\Resources\ProdutoResourceCollection;
use App\Http\Resources\ProdutoStoredResource;
use App\Http\Resources\ProdutoUpdatedResource;
use App\Interfaces\RepositoryInterface;
use App\Models\Produto;
use App\Services\ProdutoService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProdutoController extends Controller
{

    public function __construct(
        private RepositoryInterface $repository
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new ProdutoResourceCollection($this->repository->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        return new ProdutoResource($this->repository->findById($id));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProdutoStoreRequest $request, ProdutoService $produtoService)
    {
        try {
            return new ProdutoStoredResource($produtoService->create($request->validated()));
        } catch (\Exception $error) {
            return $this->errorHandler("Não foi possível criar o Produto!!! Tente mais tarde.", $error);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProdutoUpdateRequest $request, Produto $produto)
    {
        try {
            $produto->update($request->validated());
            return new ProdutoUpdatedResource($produto);
        } catch (AuthorizationException $error) {
            throw $error;
        } catch (\Exception $error) {
            return $this->errorHandler("Não foi possível atualizar o Produto!!! Tente mais tarde.", $error);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produto $produto)
    {
        try {
            Gate::authorize('delete', $produto);
            // if(Gate::denies('delete',$produto))
            //     throw new AuthorizationException("Não permitido!!!");
            $produto->delete();
            return new ProdutoResource($produto)
                ->additional(['message' => "Produto removido!!!"]);
        } catch (\Exception $error) {
            return $this->errorHandler("Não foi possível remover o Produto!!! Tente mais tarde.", $error);
        }
    }

    public function filter(Request $request)
    {
        try {
            $filteredProducts = $this->repository->filter($request);
            return new ProdutoResourceCollection($filteredProducts)
                ->additional(['total' => $filteredProducts->count()]);

        } catch (\Exception $error) {
            return $this->errorHandler("Erro ao filtrar produtos!!!", $error);
        }
    }
}
