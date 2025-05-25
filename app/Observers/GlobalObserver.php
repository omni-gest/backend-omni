<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GlobalObserver
{
    public function created (Model $model)
    {
            
        // Capturar os atributos que estão sendo atualizados
        $changes = $model->getAttributes();

        // Capturar o nome da Tabela    
        $tableName = $model->getTable();

        // Obter a chave primária
        $primaryKey = $model->getKey();

        DB::table('tb_auditoria')->insert(
            [
                'id_externo_aud' => $primaryKey,  
                'des_alteracao_aud' => 'insert', 
                'json_alteracao_aud' => json_encode($changes), 
                'des_tabela_aud' => $tableName, 
                'dth_cadastro_aud' => date('Y-m-d H:i:s')
            ]
        );

    }

    public function updated(Model $model)
    {
        // Capturar os atributos que estão sendo atualizados
        $originalAll = $model->getOriginal();
        $changes = $model->getChanges();

        $original = array_intersect_key($originalAll, $changes);

        $resultado = array_filter($original, function ($originalNew, $chave) use ($changes) {
            return $changes[$chave] !== $originalNew;
        }, ARRAY_FILTER_USE_BOTH);

       // Capturar o nome da Tabela    
       $tableName = $model->getTable();

       // Obter o valor da chave primária
       $primaryKeyValue = $model->getKey();

       DB::table('tb_auditoria')->insert(
            [
                'id_externo_aud' => $primaryKeyValue,
                'des_alteracao_aud' => 'update', 
                'json_original_aud' => json_encode($resultado), 
                'json_alteracao_aud' => json_encode($changes), 
                'des_tabela_aud' => $tableName, 
                'dth_cadastro_aud' => date('Y-m-d H:i:s')
            ]
        );

    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(Model $model): void
    {
        //
        $originalAll = $model->getOriginal();

       // Capturar o nome da Tabela    
       $tableName = $model->getTable();

       // Obter o valor da chave primária
       $primaryKeyValue = $model->getKey();

       DB::table('tb_auditoria')->insert(
            [
                'id_externo_aud' => $primaryKeyValue,
                'des_alteracao_aud' => 'delete', 
                'json_original_aud' => json_encode($originalAll), 
                'json_alteracao_aud' => json_encode([]), 
                'des_tabela_aud' => $tableName, 
                'dth_cadastro_aud' => date('Y-m-d H:i:s')
            ]
        );
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(Model $model): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(Model $model): void
    {
        //
    }
}
