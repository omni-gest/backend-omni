<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            Route::middleware(['api', 'set.empresa.header'])
                ->prefix('api/auth')
                ->group(base_path('routes/api/auth.php'));
            Route::middleware('api')
            ->prefix('api/user')
            ->group(base_path('routes/api/user.php'));
            Route::middleware(['api', 'set.empresa.header'])
                ->prefix('api/servico')
                ->group(base_path('routes/api/servico.php'));

            Route::middleware(['api', 'set.empresa.header'])
                ->prefix('api/venda')
                ->group(base_path('routes/api/venda.php'));

            Route::middleware(['api', 'set.empresa.header'])
                ->prefix('api/servicoTipo')
                ->group(base_path('routes/api/servicoTipo.php'));

            Route::middleware(['api', 'set.empresa.header'])
                ->prefix('api/material')
                ->group(base_path('routes/api/material.php'));

                Route::middleware(['api', 'set.empresa.header'])
                ->prefix('api/estoque')
                ->group(base_path('routes/api/estoque.php'));

                Route::middleware(['api', 'set.empresa.header'])
                    ->prefix('api/estoqueItem')
                    ->group(base_path('routes/api/estoqueItem.php'));

            Route::middleware(['api', 'set.empresa.header'])
                ->prefix('api/estoqueQuantidadeMaterial')
                ->group(base_path('routes/api/estoqueQuantidadeMaterial.php'));

            Route::middleware(['api', 'set.empresa.header'])
                ->prefix('api/movimentacao')
                ->group(base_path('routes/api/materialMovimentacao.php'));

            Route::middleware(['api', 'set.empresa.header'])
                ->prefix('api/cliente')
                ->group(base_path('routes/api/cliente.php'));

            Route::middleware(['api', 'set.empresa.header'])
                ->prefix('api/centroCusto')
                ->group(base_path('routes/api/centroCusto.php'));

            Route::middleware(['api', 'set.empresa.header'])
                ->prefix('api/unidade')
                ->group(base_path('routes/api/unidade.php'));

            Route::middleware(['api', 'set.empresa.header'])
                ->prefix('api/cargo')
                ->group(base_path('routes/api/cargo.php'));

            Route::middleware(['api', 'set.empresa.header'])
                ->prefix('api/funcionario')
                ->group(base_path('routes/api/funcionario.php'));

            Route::middleware(['api', 'set.empresa.header'])
                ->prefix('api/instituicaoPagamento')
                ->group(base_path('routes/api/instituicaoPagamento.php'));

            Route::middleware(['api', 'set.empresa.header'])
                ->prefix('api/metodoPagamento')
                ->group(base_path('routes/api/metodoPagamento.php'));

            Route::middleware(['api', 'set.empresa.header'])
                ->prefix('api/agendamento')
                ->group(base_path('routes/api/agendamento.php'));

            Route::middleware(['api', 'set.empresa.header'])
                ->prefix('api/agendamento')
                ->group(base_path('routes/api/agendamento.php'));

            Route::middleware(['api', 'set.empresa.header'])
                ->prefix('api/pessoa')
                ->group(base_path('routes/api/pessoa.php'));

            Route::middleware(['api', 'set.empresa.header'])
                ->prefix('api/fornecedor')
                ->group(base_path('routes/api/fornecedor.php'));

            Route::middleware(['api', 'set.empresa.header'])
                ->prefix('api/status')
                ->group(base_path('routes/api/status.php'));

            Route::middleware(['api', 'set.empresa.header'])
                ->prefix('api/usuarioMenu')
                ->group(base_path('routes/api/usuarioMenu.php'));

            Route::middleware(['api', 'set.empresa.header'])
                ->prefix('api/empresaMenu')
                ->group(base_path('routes/api/empresaMenu.php'));

            Route::middleware(['api', 'set.empresa.header'])
                ->prefix('api/empresa')
                ->group(base_path('routes/api/empresa.php'));

            Route::middleware(['api', 'set.empresa.header'])
                ->prefix('api/user')
                ->group(base_path('routes/api/user.php'));

            Route::middleware(['api', 'set.empresa.header'])
            ->prefix('api/empresa-menu')
            ->group(base_path('routes/api/empresaMenu.php'));

            Route::middleware(['api', 'set.empresa.header'])
                ->prefix('api/usuario-menu')
                ->group(base_path('routes/api/usuarioMenu.php'));

            Route::middleware(['api', 'set.empresa.header'])
                ->prefix('api/menu')
                ->group(base_path('routes/api/menu.php'));

            Route::middleware(['api', 'set.empresa.header'])
                ->prefix('api/usuarioCentroCusto')
                ->group(base_path('routes/api/usuarioCentroCusto.php'));

            Route::middleware(['api', 'set.empresa.header'])
                ->prefix('api/origemCliente')
                ->group(base_path('routes/api/origemCliente.php'));

            Route::middleware(['api', 'set.empresa.header'])
                ->prefix('api/financeiro')
                ->group(base_path('routes/api/financeiro.php'));

            Route::middleware(['api', 'set.empresa.header'])
                ->prefix('api/usuario-estoque')
                ->group(base_path('routes/api/relUsuarioEstoque.php'));

            Route::middleware(['api', 'set.empresa.header'])
                ->prefix('api/combo')
                ->group(base_path('routes/api/combo.php'));
        });
    }
}
