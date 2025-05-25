<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AddIdEmpresaToRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Verifica se o cabeçalho de autorização está presente
        if ($request->hasHeader('Authorization')) {
            $authHeader = $request->header('Authorization');
            $token = str_replace('Bearer ', '', $authHeader);

            // Decodifica o token JWT
            try {
                $decoded = JWT::decode($token, new Key(config('jwt.secret'), 'HS256'));
                if (isset($decoded->id_empresa_d)) {
                    $request->headers->set('id_empresa_d', $decoded->id_empresa_d);
                }
                if (isset($decoded->id_usuario_d)) {
                    $request->headers->set('id_usuario_d', $decoded->id_usuario_d);
                }
            } catch (\Exception $e) {
                return response()->json(['error' => 'Token inválido'], 401);
            }
        }

        // Continua a requisição
        return $next($request);
    }
}
