<?php

namespace App\Providers;

use App\Interfaces\ProdutoRepositoryInterface;
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
    //     ProdutoRepositoryInterface::class => ProdutoRepository::class,
    // ];

    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(ProdutoRepositoryInterface::class, ProdutoRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
