<?php

$files = glob(__DIR__ . '/../seeders/Tenant/Permissions/{Carrier,CarrierUnit,Driver,Shipment,ShipmentOrderPiece,ShipmentDriver,EntityAddress}*Seeder.php', GLOB_BRACE);

foreach ($files as $file) {
    $bytes = file_get_contents($file);

    if (str_starts_with($bytes, "\xEF\xBB\xBF")) {
        $bytes = substr($bytes, 3);
    }

    file_put_contents($file, $bytes);
}

echo 'Fixed ' . count($files) . " files\n";
