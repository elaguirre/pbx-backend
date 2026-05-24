<?php

namespace App\Models\Traits;

trait HasTimezones
{
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->toUserTz()->format('Y-m-d H:i:s');
    }
}

