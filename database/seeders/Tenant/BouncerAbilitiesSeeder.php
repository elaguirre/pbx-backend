<?php

namespace Database\Seeders\Tenant;

use Database\Seeders\Tenant\Concerns\UpsertsAbilities;
use Database\Seeders\Tenant\Permissions\ClientPermissionsSeeder;
use Database\Seeders\Tenant\Permissions\ContactDataPermissionsSeeder;
use Database\Seeders\Tenant\Permissions\EntityPermissionsSeeder;
use Database\Seeders\Tenant\Permissions\ProductPermissionsSeeder;
use Database\Seeders\Tenant\Permissions\PiecePermissionsSeeder;
use Database\Seeders\Tenant\Permissions\MaterialPermissionsSeeder;
use Database\Seeders\Tenant\Permissions\SupplierPermissionsSeeder;
use Database\Seeders\Tenant\Permissions\ManufacturerPermissionsSeeder;
use Database\Seeders\Tenant\Permissions\MaterialSupplierPermissionsSeeder;
use Database\Seeders\Tenant\Permissions\MaterialSupplierPricePermissionsSeeder;
use Database\Seeders\Tenant\Permissions\ProductPiecePermissionsSeeder;
use Database\Seeders\Tenant\Permissions\PieceMaterialPermissionsSeeder;
use Database\Seeders\Tenant\Permissions\OrderConceptPermissionsSeeder;
use Database\Seeders\Tenant\Permissions\OrderPiecePermissionsSeeder;
use Database\Seeders\Tenant\Permissions\OrderPieceStatusPermissionsSeeder;
use Database\Seeders\Tenant\Permissions\OrderPermissionsSeeder;
use Database\Seeders\Tenant\Permissions\ProductionBatchPermissionsSeeder;
use Database\Seeders\Tenant\Permissions\ProductionOrderPermissionsSeeder;
use Database\Seeders\Tenant\Permissions\ManufacturerPieceCostPermissionsSeeder;
use Database\Seeders\Tenant\Permissions\ManufacturerOrderPiecePermissionsSeeder;
use Database\Seeders\Tenant\Permissions\ManufacturingFollowUpPermissionsSeeder;
use Database\Seeders\Tenant\Permissions\CarrierPermissionsSeeder;
use Database\Seeders\Tenant\Permissions\CarrierUnitPermissionsSeeder;
use Database\Seeders\Tenant\Permissions\DriverPermissionsSeeder;
use Database\Seeders\Tenant\Permissions\ShipmentPermissionsSeeder;
use Database\Seeders\Tenant\Permissions\ShipmentOrderPiecePermissionsSeeder;
use Database\Seeders\Tenant\Permissions\ShipmentDriverPermissionsSeeder;
use Database\Seeders\Tenant\Permissions\ShipmentRoutePermissionsSeeder;
use Database\Seeders\Tenant\Permissions\EntityAddressPermissionsSeeder;
use Database\Seeders\Tenant\Permissions\UserPermissionsSeeder;
use Illuminate\Database\Seeder;

class BouncerAbilitiesSeeder extends Seeder
{
    use UpsertsAbilities;

    public function run(): void
    {
        $this->call([
            ProductPermissionsSeeder::class,
            PiecePermissionsSeeder::class,
            MaterialPermissionsSeeder::class,
            SupplierPermissionsSeeder::class,
            ManufacturerPermissionsSeeder::class,
            MaterialSupplierPermissionsSeeder::class,
            MaterialSupplierPricePermissionsSeeder::class,
            ProductPiecePermissionsSeeder::class,
            PieceMaterialPermissionsSeeder::class,
            UserPermissionsSeeder::class,
            EntityPermissionsSeeder::class,
            ContactDataPermissionsSeeder::class,
            ClientPermissionsSeeder::class,
            OrderPermissionsSeeder::class,
            OrderConceptPermissionsSeeder::class,
            OrderPiecePermissionsSeeder::class,
            OrderPieceStatusPermissionsSeeder::class,
            ProductionBatchPermissionsSeeder::class,
            ProductionOrderPermissionsSeeder::class,
            ManufacturerPieceCostPermissionsSeeder::class,
            ManufacturerOrderPiecePermissionsSeeder::class,
            ManufacturingFollowUpPermissionsSeeder::class,
            CarrierPermissionsSeeder::class,
            CarrierUnitPermissionsSeeder::class,
            DriverPermissionsSeeder::class,
            ShipmentPermissionsSeeder::class,
            ShipmentOrderPiecePermissionsSeeder::class,
            ShipmentDriverPermissionsSeeder::class,
            ShipmentRoutePermissionsSeeder::class,
            EntityAddressPermissionsSeeder::class,
        ]);

        $this->upsertAbilities([
            ['group' => 'Roles', 'name' => 'roles.access', 'title' => 'Ver roles', 'description' => 'Acceder al módulo de roles.'],
            ['group' => 'Roles', 'name' => 'roles.save', 'title' => 'Editar roles', 'description' => 'Editar y crear roles.'],
            ['group' => 'Usuarios', 'name' => 'me.password_expires', 'title' => 'La contraseña del usuario expira', 'description' => 'Actualizar contraseña cada 90 días.'],
            ['group' => 'Usuarios', 'name' => 'me.require_2fa', 'title' => 'Requiere 2FA', 'description' => 'Autenticación en dos factores.'],
            ['group' => 'Tenants', 'name' => 'tenants.access', 'title' => 'Ver tenants', 'description' => 'Listar tenants del sistema.'],
            ['group' => 'Configuración', 'name' => 'settings.save', 'title' => 'Editar configuración', 'description' => 'Editar ajustes del tenant.'],
        ]);
    }
}
