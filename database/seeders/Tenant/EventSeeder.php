<?php

namespace Database\Seeders\Tenant;

use App\Actions\UpsertEventsFromJson;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UpsertEventsFromJson::run([
            "state" => "CHIHUAHUA",
            "city" => "CHIHUAHUA",
            "place" => "Centro de la ciudad",
            "layout" => "general",
            "events" => [
                [
                    "event" => [
                        "title" => "EVENTO DE PRUEBA " . now()->format('Y'),
                        "description" => "¡Prepárate para vivir una noche inolvidable!",
                        "date" => "2030-01-01",
                        "hour" => "20:00",
                        "age_limit_label" => 'Para mayores de 18 años con identificación oficial.',
                        "seat_description" => "Evento solo para mayores",
                        "web_domain" => null,
                        "monthly_installments" => "3,6",
                        "tags" => [
                            "todos",
                            "chihuahua"
                        ]
                    ],
                    "prices" => [
                        "GRAL DE PIE" => [
                            "price" => 500,
                            "commission" => 70
                        ]
                    ]
                ]
            ],
            "areas" => [
                [
                    "area" => "GRAL DE PIE",
                    "total" => 2000,
                    "seats_type" => "general",
                    "rows" => "[{\"row\":\"1\",\"columns\":2000,\"x\":0,\"y\":0}]"
                ]
            ]
        ]);
    }
}
