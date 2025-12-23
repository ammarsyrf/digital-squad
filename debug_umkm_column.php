<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$tableName = 'umkm';
$columnName = 'status_verifikasi';

$results = DB::select("SHOW COLUMNS FROM {$tableName} WHERE Field = '{$columnName}'");

foreach ($results as $column) {
    echo "Field: " . $column->Field . "\n";
    echo "Type: " . $column->Type . "\n";
    echo "Null: " . $column->Null . "\n";
    echo "Key: " . $column->Key . "\n";
    echo "Default: " . $column->Default . "\n";
    echo "Extra: " . $column->Extra . "\n";
}
