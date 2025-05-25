<?php

namespace App\Models;

use App\Enums\OrigemStatusEnum;
use App\Enums\StatusVendaEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $table = "tb_status";

    protected $fillable = [
        'origem_sts',
        'status_sts',
        'des_status_sts',
        'is_ativo',
    ];


    public static function getByOrigem(int $origem)
    {
        $data = Status::
        where('origem_sts', $origem)
        ->get();
        return response()->json($data);
    }

    public static function getById(Int $id_status)
    {
        return Status::
        select(['*'])
        ->where('id_status_sts', $id_status)
        ->get()[0];
    }

    public static function getByOrigemStatus(Int $origem, Int $status)
    {
        return Status::
        where('origem_sts', $origem)
        ->where('status_sts', $status)
        ->first();
    }

}
