<?php
// Mark migration as ran
require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

DB::table('migrations')->insert([
    'migration' => '2025_12_04_101847_create_messages_table',
    'batch' => 1
]);

echo "Migration marked as ran successfully!\n";
