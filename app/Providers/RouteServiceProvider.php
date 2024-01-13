<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->routes(function (): void {
            $this->routesAdmin();
            $this->routesApi();
        });
    }

    private function routesAdmin(): void
    {
        Route::middleware('web')
            ->group(base_path('routes/admin.php'));
    }

    private function routesApi(): void
    {
        Route::middleware('api')
            ->prefix('api/v1')
            ->group(base_path('routes/api.php'));
    }
}
