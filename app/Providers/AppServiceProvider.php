<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Pagination\Paginator;
use App\Models\Pedido;
use App\Observers\PedidoObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Detrás de un proxy (Render/Railway) con HTTPS: fuerza que todas las
        // URLs (asset, url, route, redirects) se generen con https y evitar
        // el bloqueo de contenido mixto.
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        // Registrar el Observer para Pedido
        Pedido::observe(PedidoObserver::class);
        
        // Usar la vista de paginación personalizada por defecto
        Paginator::defaultView('pagination::custom');
        Paginator::defaultSimpleView('pagination::simple-default');
    }
}
