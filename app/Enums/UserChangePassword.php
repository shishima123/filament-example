<?php

namespace App\Enums;

enum UserChangePassword: int
{
    case NO_CHANGE = 0;
    case CHANGED = 1;
}
