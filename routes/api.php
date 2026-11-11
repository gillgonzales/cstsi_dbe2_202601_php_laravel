<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LoginTokensController;
use App\Http\Controllers\Api\FornecedorController;
use App\Http\Controllers\Api\ProdutoController;
use App\Http\Controllers\Api\UserController;
use App\Models\Produto;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {

    Route::get('produtos/filter/', [ProdutoController::class, 'filter'])->name('produtos.filter');;
    Route::query('produtos/', [ProdutoController::class, 'filter'])->name('produtos.query');

    Route::apiResource('produtos', ProdutoController::class);

    Route::apiResource('fornecedores', FornecedorController::class)
        ->parameters(["fornecedores" => 'fornecedor']);

    Route::apiResource('fornecedores', FornecedorController::class)->only('index');

    Route::apiResource('users', UserController::class)
        ->only(['store']);

    Route::apiResource('users', UserController::class)
        ->only(['index', 'show', 'update'])
        ->middleware('auth:sanctum');

    Route::apiResource('users', UserController::class)
        ->only('destroy')
        ->middleware(['auth:sanctum', 'ability:is_admin']);

    Route::apiResource('produtos', ProdutoController::class)
        ->except(['index', 'show'])
        ->middleware('auth:sanctum');

    Route::post('login', [LoginController::class, 'login']);
    Route::post('logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');
    Route::get('user', [LoginController::class, 'user'])->middleware('auth:sanctum');

    Route::prefix('token')->group(function () {
        Route::post('login', [LoginTokensController::class, 'login']);


        Route::get('user', function (Request $request) {
            return $request->user();
        })->middleware('auth:sanctum');

        #Replicando rotas para tokens
        Route::apiResource('users', UserController::class)
            ->only(['store']);

        Route::apiResource('users', UserController::class)
            ->only(['index', 'show', 'update'])
            ->middleware('auth:sanctum');

        Route::apiResource('users', UserController::class)
            ->only('destroy')
            ->middleware(['auth:sanctum', 'ability:is_admin']);

        Route::apiResource('produtos', ProdutoController::class)
            ->except(['index', 'show'])
            ->middleware('auth:sanctum');
    });
});
