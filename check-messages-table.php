<?php
// Check messages table structure
require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$columns = DB::select("DESCRIBE messages");

echo "Current messages table structure:\n";
echo "=================================\n";
foreach ($columns as $column) {
    echo "Field: {$column->Field}, Type: {$column->Type}, Null: {$column->Null}, Key: {$column->Key}, Default: {$column->Default}\n";
}
