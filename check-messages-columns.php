<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== MESSAGES TABLE COLUMNS ===\n\n";

$columns = Schema::getColumnListing('messages');
foreach ($columns as $col) {
    echo "- $col\n";
}
