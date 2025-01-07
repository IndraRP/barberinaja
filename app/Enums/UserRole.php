<?php

namespace App\Enums;

enum UserRole: string
{
    case Owner = 'owner';
    case Barber = 'barber';
    case Customer = 'customer';
}