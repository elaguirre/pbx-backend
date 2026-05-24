<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('shipment_routes', 'address_id')) {
            return;
        }

        DB::statement('ALTER TABLE shipment_routes ADD INDEX shipment_routes_shipment_id_index (shipment_id)');
        DB::statement('ALTER TABLE shipment_routes DROP INDEX shipment_routes_shipment_id_address_id_unique');
        DB::statement('ALTER TABLE shipment_routes DROP INDEX shipment_routes_address_id_foreign');
        DB::statement('ALTER TABLE shipment_routes CHANGE address_id entity_address_id BIGINT UNSIGNED NOT NULL');
        DB::statement(
            'ALTER TABLE shipment_routes
                ADD CONSTRAINT shipment_routes_entity_address_id_foreign
                FOREIGN KEY (entity_address_id) REFERENCES entity_addresses (id),
                ADD UNIQUE shipment_routes_shipment_id_entity_address_id_unique (shipment_id, entity_address_id)',
        );
    }

    public function down(): void
    {
        if (! Schema::hasColumn('shipment_routes', 'entity_address_id')) {
            return;
        }

        DB::statement('ALTER TABLE shipment_routes DROP FOREIGN KEY shipment_routes_entity_address_id_foreign');
        DB::statement('ALTER TABLE shipment_routes DROP INDEX shipment_routes_shipment_id_entity_address_id_unique');
        DB::statement('ALTER TABLE shipment_routes CHANGE entity_address_id address_id BIGINT UNSIGNED NOT NULL');
        DB::statement(
            'ALTER TABLE shipment_routes
                ADD INDEX shipment_routes_address_id_foreign (address_id),
                ADD UNIQUE shipment_routes_shipment_id_address_id_unique (shipment_id, address_id)',
        );
        DB::statement('ALTER TABLE shipment_routes DROP INDEX shipment_routes_shipment_id_index');
    }
};
