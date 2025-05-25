<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Enums\OrigemStatusEnum;
use App\Models\Status;

class StatusController extends Controller
{
    public function getByOrigem(int $origem)
    {
        return Status::getByOrigem($origem);
    }
}
