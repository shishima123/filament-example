<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case SUCCEEDED = 'succeeded';
    case FAILED = 'failed';
}
