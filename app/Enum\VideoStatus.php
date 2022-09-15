<?php
namespace App\Enums;

use Illuminate\Validation\Rules\Enum;

enum VideoStatus
{
    case Open;
    case Sending;
    case Sended;
    case LogoSended;
    case Completed;
}
