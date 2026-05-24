<?php

namespace Database\Seeders\Tenant;

use App\Models\Country;
use App\Models\Setting;
use App\Models\TicketTemplate;
use Illuminate\Database\Seeder;

class TicketTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TicketTemplate::insert([
            "name" => "default",
            "structure" => '{"fields": [{"x": 381, "y": 151, "type": "text", "column": "id", "fontSize": 24}, {"x": 381, "y": 610, "type": "text", "column": "id", "fontSize": 24}, {"x": 381, "y": 283, "size": 4, "type": "qr", "column": "code"}, {"x": 381, "y": 742, "size": 4, "type": "qr", "column": "code"}, {"x": 100, "y": 207, "type": "barcode", "column": "code", "height": 45}, {"x": 445, "y": 285, "type": "text", "value": "CONSERVA TU BOLETO SIEMPRE", "fontSize": 20, "orientation": "R"}, {"x": 0, "y": 231, "type": "text", "align": "center", "column": "access", "fontSize": 24, "containerWidth": 381}, {"x": 0, "y": 288, "type": "text", "align": "center", "column": "event", "fontSize": 28}, {"x": 0, "y": 345, "type": "text", "align": "center", "column": "place", "fontSize": 24}, {"x": 0, "y": 375, "type": "text", "align": "center", "column": "seat_description", "fontSize": 20}, {"x": 0, "y": 420, "type": "text", "align": "center", "column": "date_time", "fontSize": 28}, {"x": 15, "y": 470, "type": "text", "value": "Zona", "fontSize": 28}, {"x": 15, "y": 495, "type": "text", "column": "area", "fontSize": 24}, {"x": 180, "y": 470, "type": "text", "value": "Fila", "fontSize": 28}, {"x": 180, "y": 495, "type": "text", "column": "row", "fontSize": 24}, {"x": 340, "y": 470, "type": "text", "value": "Asiento", "fontSize": 28}, {"x": 340, "y": 495, "type": "text", "column": "column", "fontSize": 24}, {"x": 15, "y": 540, "type": "text", "value": "Precio", "fontSize": 28}, {"x": 15, "y": 565, "type": "text", "column": "price", "fontSize": 24}, {"x": 180, "y": 540, "type": "text", "value": "CGO.SERV.", "fontSize": 28}, {"x": 180, "y": 565, "type": "text", "column": "service", "fontSize": 24}, {"x": 340, "y": 540, "type": "text", "value": "Total", "fontSize": 28}, {"x": 340, "y": 565, "type": "text", "column": "total", "fontSize": 24}, {"x": 0, "y": 632, "type": "text", "align": "center", "column": "access", "fontSize": 24, "containerWidth": 381}, {"x": 0, "y": 660, "type": "text", "align": "center", "column": "event", "fontSize": 24, "containerWidth": 381}, {"x": 0, "y": 720, "type": "text", "align": "center", "column": "date_time", "fontSize": 20, "containerWidth": 381}, {"x": 15, "y": 750, "type": "text", "value": "Zona", "fontSize": 24}, {"x": 15, "y": 775, "type": "text", "column": "area", "fontSize": 20}, {"x": 160, "y": 750, "type": "text", "value": "Fila", "fontSize": 24}, {"x": 160, "y": 775, "type": "text", "column": "row", "fontSize": 20}, {"x": 260, "y": 750, "type": "text", "value": "Asiento", "fontSize": 24}, {"x": 260, "y": 775, "type": "text", "column": "column", "fontSize": 20}, {"x": 160, "y": 810, "type": "text", "value": "Precio", "fontSize": 24}, {"x": 160, "y": 835, "type": "text", "column": "price", "fontSize": 20}, {"x": 260, "y": 810, "type": "text", "value": "CGO.SERV.", "fontSize": 24}, {"x": 260, "y": 835, "type": "text", "column": "service", "fontSize": 20}, {"x": 380, "y": 810, "type": "text", "value": "Total", "fontSize": 24}, {"x": 380, "y": 835, "type": "text", "column": "total", "fontSize": 20}], "printMode": "T", "labelWidth": 503, "labelHeight": 1123}',
        ]);
    }
}
