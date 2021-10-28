<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repository\Eloquent\BaseRepository;
use App\Repository\Eloquent\LojaRepository;
use App\Repository\Eloquent\ProdutoRepository;
use App\Repository\EloquentRepositoryInterface;
use App\Repository\LojaRepositoryInterface;
use App\Repository\ProdutoRepositoryInterface;
use Illuminate\Auth\EloquentUserProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(EloquentRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(LojaRepositoryInterface::class, LojaRepository::class);
        $this->app->bind(ProdutoRepositoryInterface::class, ProdutoRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
