<?php

namespace App\Enums;

enum FinanceiroReferenciaEnum: int
{
    case Manual = 0;
    case Venda = 1;
    case Serviço = 2;
    case Compra = 3;
}