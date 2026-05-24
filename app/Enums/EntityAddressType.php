<?php

namespace App\Enums;

enum EntityAddressType: string
{
    case Home = 'home';
    case Billing = 'billing';
    case Shipping = 'shipping';
    case Work = 'work';
    case Mailing = 'mailing';
}
