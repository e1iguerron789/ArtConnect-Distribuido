<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\EventoRepository;
use App\Services\EventoRecomendadorService;
use App\Recomendacion\Reglas\ReglaInteresExacto;
use App\Recomendacion\Reglas\ReglaNombreInteres;
use App\Recomendacion\Reglas\ReglaDistancia;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(EventoRecomendadorService::class, function ($app) {
            return new EventoRecomendadorService(
                $app->make(EventoRepository::class),
                [
                    new ReglaInteresExacto(),
                    new ReglaNombreInteres(),
                    new ReglaDistancia(),
                ]
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
