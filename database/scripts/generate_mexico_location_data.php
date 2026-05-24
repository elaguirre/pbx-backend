<?php

$stateSrc = file_get_contents(__DIR__ . '/../seeders/Tenant/StateSeeder.php');
preg_match_all("/'id'\s*=>\s*(\d+).*?'state'\s*=>\s*'((?:[^'\\\\]|\\\\.)*)'/s", $stateSrc, $stateMatches, PREG_SET_ORDER);
$states = [];

foreach ($stateMatches as $match) {
    $states[] = [
        'id' => (int) $match[1],
        'name' => stripcslashes($match[2]),
    ];
}

$citySrc = file_get_contents(__DIR__ . '/../seeders/Tenant/CitySeeder.php');
preg_match_all("/\[\s*'id'\s*=>\s*(\d+),\s*'state_id'\s*=>\s*(\d+),\s*'city'\s*=>\s*'((?:[^'\\\\]|\\\\.)*)'/", $citySrc, $cityMatches, PREG_SET_ORDER);
$cities = [];

foreach ($cityMatches as $match) {
    $cities[] = [
        'id' => (int) $match[1],
        'name' => stripcslashes($match[3]),
        'state_id' => (int) $match[2],
    ];
}

$dataDir = __DIR__ . '/../data';

if (! is_dir($dataDir)) {
    mkdir($dataDir, 0777, true);
}

file_put_contents($dataDir . '/mexico_states.php', "<?php\n\nreturn " . var_export($states, true) . ";\n");
file_put_contents($dataDir . '/mexico_cities.php', "<?php\n\nreturn " . var_export($cities, true) . ";\n");

echo count($states) . " states, " . count($cities) . " cities\n";
