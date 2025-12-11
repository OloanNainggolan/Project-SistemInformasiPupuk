<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "Creating admin_activities table...\n";

try {
    DB::statement("
        CREATE TABLE IF NOT EXISTS `admin_activities` (
            `id` bigint unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `action` varchar(255) NOT NULL,
            `description` varchar(255) NOT NULL,
            `module` varchar(255) NULL,
            `related_id` int NULL,
            `ip_address` varchar(255) NULL,
            `user_agent` varchar(255) NULL,
            `changes` text NULL,
            `status` enum('success', 'failed') NOT NULL DEFAULT 'success',
            `created_at` timestamp NULL,
            `updated_at` timestamp NULL,
            INDEX `admin_activities_action_index` (`action`),
            INDEX `admin_activities_module_index` (`module`),
            INDEX `admin_activities_created_at_index` (`created_at`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    
    echo "✅ Table admin_activities created successfully!\n";
    
    // Mark migration as run
    DB::table('migrations')->insert([
        'migration' => '2025_12_09_093139_create_admin_activities_table',
        'batch' => DB::table('migrations')->max('batch') + 1
    ]);
    
    echo "✅ Migration marked as completed!\n";
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
