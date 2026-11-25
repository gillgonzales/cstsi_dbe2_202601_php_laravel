<?php

namespace App\Providers;

use App\Http\Controllers\Api\ProdutoController;
use App\Interfaces\RepositoryInterface;
use App\Repositories\ProdutoRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryInterfacesProvider extends ServiceProvider
{
       /**
     * All of the container bindings that should be registered.
     *
     * @var array
     */
    //  public $bindings = [
    //     RepositoryInterface::class => ProdutoRepository::class,
    // ];

    /**
     * Register services.
     */
    public function register(): void
    {
        // $this->app->bind(RepositoryInterface::class, ProdutoRepository::class);
        $this->app->when(ProdutoController::class)
                    ->needs(RepositoryInterface::class)
                    ->give(ProdutoRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
