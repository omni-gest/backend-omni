<?php

namespace App\Enums;

enum StatusVendaEnum: int
{
    case Aberta = 0;
    case Negociando = 1;
    case Finalizada = 2;
    case Cancelada = 3;
}
