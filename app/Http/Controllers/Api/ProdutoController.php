<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Http\Requests\ProdutoStoreRequest;
use App\Http\Requests\ProdutoUpdateRequest;
use App\Http\Resources\ProdutoResource;
use App\Http\Resources\ProdutoResourceCollection;
use App\Http\Resources\ProdutoStoredResource;
use App\Http\Resources\ProdutoUpdatedResource;
use App\Models\Produto;
use App\Repositories\ProdutoRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return response()->json(Produto::all());
        return new ProdutoResourceCollection(Produto::all()->load('links','fornecedor'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Produto $produto)
    {
        //  return response()->json($produto);
        return new ProdutoResource($produto->load('links','fornecedor.estado.regiao'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProdutoStoreRequest $request)
    {
        try {
            return new ProdutoStoredResource(ProdutoRepository::store($request->validated()));
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

        //https://app.notion.com/p/prof-gillgonzales-ifsul/Aula-09-ORM-Parte-1-Relacionamentos-com-o-Eloquent-20c1037386bf80fe99dfe0a17d847b5d?source=copy_link#20c1037386bf81ed8679cabde5e5762c
        // Produto::where('importado',1)
        // 		->whereBetween('preco',[100,2000])
        // 		->whereHas('fornecedor',
        // 					fn($q)=>
        // 							$q->whereHas('estado',fn($q)=>
        // 									$q->whereHas('regiao',
        // 											fn($q)=>
        // 												$q->where('nome','like','Sul'))))
        // 		->get()

        try {
            $importado = $request->has('importado') ? $request->importado : 0;
            $min = $request->has('min') ? $request->min : 1;
            $max = $request->has('max') ? $request->max : 99999;

            // if ($request->has('nome'))
            //     $queryBuilderFilter->where('nome','like',"%$request->nome%");

            // if ($request->hasAny(['min', 'max']))
            //     $queryBuilderFilter->whereBetween('preco', [$min, $max]);

            // if ($request->has('regiao'))
            //     $queryBuilderFilter->porRegiao($request->regiao);

            // if ($request->has('importado'))
            //     $queryBuilderFilter->importados($importado);

            $queryBuilderFilter = Produto::with('fornecedor.estado.regiao');
            $request->has('nome') && $queryBuilderFilter->where('nome','like',"%$request->nome%");
            $request->hasAny(['min', 'max']) && $queryBuilderFilter->whereBetween('preco', [$min, $max]);
            $request->has('regiao') && $queryBuilderFilter->porRegiao($request->regiao);
            $request->has('importado') && $queryBuilderFilter->importados($importado);

            // dd($queryBuilderFilter->toSql());

            $filteredProducts =  $queryBuilderFilter->get();

            return new ProdutoResourceCollection($filteredProducts)
                ->additional(['total' => $filteredProducts->count()]);

        } catch (\Exception $error) {
            return $this->errorHandler("Erro ao filtrar produtos!!!", $error);
        }
    }
}
