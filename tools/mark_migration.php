<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$migration = $argv[1] ?? null;
$batch = isset($argv[2]) ? (int)$argv[2] : null;
if (! $migration || ! $batch) {
    echo "Usage: php tools/mark_migration.php <migration_name> <batch>\n";
    exit(1);
}

$db = $app->make('db');
$db->table('migrations')->insert([
    'migration' => $migration,
    'batch' => $batch,
]);

echo "Inserted migration $migration with batch $batch\n";
