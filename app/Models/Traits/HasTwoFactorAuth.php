<?php

namespace App\Models\Traits;

use App\Models\TwoFactorAuthCode;
use App\Notifications\TwoFactorAuthNotification;
use \Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasTwoFactorAuth
{
    public function check2fa($code): bool
    {
        return $this->twoFactorAuthCodes()->where('code', $code)->isValid()->exists();
    }

    public function send2faCode(): void
    {
        $code = random_int(1000000, 9999999);

        $this->twoFactorAuthCodes()->create([
            'code' => $code,
            'valid_until' => now()->addMinutes(5),
        ]);

        $this->notify(new TwoFactorAuthNotification($code));
    }

    public function twoFactorAuthCodes(): MorphMany
    {
        return $this->morphMany(TwoFactorAuthCode::class, 'entity');
    }
}
