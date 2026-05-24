<?php

namespace Database\Seeders\Tenant\Concerns;

use Silber\Bouncer\BouncerFacade as Bouncer;

trait UpsertsAbilities
{
    protected function upsertAbilities(array $abilities): void
    {
        foreach ($abilities as $ability) {
            Bouncer::ability()->updateOrCreate(
                ['name' => $ability['name']],
                $ability
            );
        }
    }
}
