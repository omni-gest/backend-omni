<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use App\Models\AuditoriaUser;
use Illuminate\Support\Facades\Log;


class AuditoriaObserver
{
    public function created(Model $model)
    {
        $this->salvar('criado', $model, [], $model->getAttributes());
    }

    public function updated(Model $model)
    {
        $old = $model->getOriginal();
        $new = $model->getDirty();
        $this->salvar('atualizado', $model, $old, $new);
    }

    public function deleted(Model $model)
    {
        $this->salvar('excluído', $model, $model->getAttributes(), []);
    }

    protected function salvar(string $evento, Model $model, array $anteriores, array $novos)
    {
        try {
            AuditoriaUser::withoutEvents(function () use ($evento, $model, $anteriores, $novos) {
                AuditoriaUser::create([
                    'modelo' => get_class($model),
                    'registro_id' => $model->getKey(),
                    'usuario_id' => auth()->id(),
                    'evento' => $evento,
                    'valores_anteriores' => $anteriores,
                    'valores_novos' => $novos,
                    'url' => request()->fullUrl(),
                    'rota' => request()->route() ? request()->route()->getName() : null,
                    'metodo' => request()->method(),
                ]);
            });
        } catch (\Throwable $e) {
            Log::error('Erro ao salvar auditoria: ' . $e->getMessage());
        }
    }
}