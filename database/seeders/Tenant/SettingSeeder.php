<?php

namespace Database\Seeders\Tenant;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $tenantId = tenant('id');

        $settings = [
            [
                'key' => 'site.name',
                'type' => 'string',
                'value' => $tenantId,
                'visible' => 1,
                'visible_on_web' => 1,
                'editable' => 1,
            ],
            [
                'key' => 'site.logo',
                'type' => 'string',
                'value' => null,
                'visible' => 1,
                'visible_on_web' => 1,
                'editable' => 1,
            ],
            [
                'key' => 'app.title',
                'type' => 'string',
                'value' => 'PBX',
                'visible' => 1,
                'visible_on_web' => 1,
                'editable' => 1,
            ],
        ];

        foreach ($settings as $setting) {
            Setting::query()->updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
