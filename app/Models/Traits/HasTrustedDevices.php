<?php

namespace App\Models\Traits;

use App\Models\TrustedDevice;
use http\Env\Request;

trait HasTrustedDevices
{
    public function isTrustedDevice(?string $fingerprint = null): bool
    {
        if (!$fingerprint) {
            return false;
        }

        return $this->devices()->where('fingerprint', $fingerprint)->isValid()->exists();
    }

    public function createTrustedDevice($fingerprint, $days = 30): \Illuminate\Database\Eloquent\Model
    {
        $device = $this->devices()->create([
            'fingerprint' => $fingerprint,
            'valid_until' => now()->addDays($days),
        ]);

        return $device;
    }

    public function devices()
    {
        return $this->morphMany(TrustedDevice::class, 'entity');
    }
}
