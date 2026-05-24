<?php

namespace App\Enums;

enum ContactDataType: string
{
    case Email = 'email';
    case Phone = 'phone';
    case Whatsapp = 'whatsapp';
}
