<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== HOSTING READINESS CHECK ===\n\n";

// 1. Check .env configuration
echo "✓ Checking .env configuration...\n";

$criticalEnvVars = [
    'APP_KEY' => env('APP_KEY'),
    'APP_ENV' => env('APP_ENV'),
    'APP_DEBUG' => env('APP_DEBUG'),
    'DB_CONNECTION' => env('DB_CONNECTION'),
    'DB_HOST' => env('DB_HOST'),
    'DB_DATABASE' => env('DB_DATABASE'),
    'SESSION_DRIVER' => env('SESSION_DRIVER'),
];

foreach ($criticalEnvVars as $key => $value) {
    if (empty($value)) {
        echo "  ✗ $key is NOT SET!\n";
    } else {
        if ($key === 'APP_KEY') {
            echo "  ✓ $key is set\n";
        } else {
            echo "  ✓ $key = $value\n";
        }
    }
}

// Check APP_KEY
if (empty(env('APP_KEY'))) {
    echo "\n⚠️ WARNING: APP_KEY not set! Run: php artisan key:generate\n";
}

// 2. Check directory permissions
echo "\n✓ Checking directory permissions...\n";

$writableDirs = [
    'storage',
    'storage/framework',
    'storage/framework/cache',
    'storage/framework/sessions',
    'storage/framework/views',
    'storage/logs',
    'public/images',
    'public/images/products',
];

foreach ($writableDirs as $dir) {
    $path = base_path($dir);
    if (!file_exists($path)) {
        echo "  ✗ Directory '$dir' does NOT EXIST!\n";
    } elseif (!is_writable($path)) {
        echo "  ⚠️ Directory '$dir' is NOT WRITABLE!\n";
    } else {
        echo "  ✓ Directory '$dir' is writable\n";
    }
}

// 3. Check required PHP extensions
echo "\n✓ Checking required PHP extensions...\n";

$requiredExtensions = [
    'pdo_mysql',
    'mbstring',
    'openssl',
    'tokenizer',
    'xml',
    'ctype',
    'json',
    'bcmath',
    'fileinfo',
    'gd',
];

foreach ($requiredExtensions as $ext) {
    if (extension_loaded($ext)) {
        echo "  ✓ Extension '$ext' is loaded\n";
    } else {
        echo "  ✗ Extension '$ext' is NOT LOADED!\n";
    }
}

// 4. Check .htaccess in public
echo "\n✓ Checking .htaccess file...\n";

if (file_exists(public_path('.htaccess'))) {
    echo "  ✓ .htaccess exists in public directory\n";
    
    $htaccess = file_get_contents(public_path('.htaccess'));
    if (strpos($htaccess, 'RewriteEngine') !== false) {
        echo "  ✓ .htaccess contains RewriteEngine directive\n";
    } else {
        echo "  ⚠️ .htaccess might be incomplete\n";
    }
} else {
    echo "  ✗ .htaccess NOT FOUND in public directory!\n";
}

// 5. Check storage link
echo "\n✓ Checking storage link...\n";

if (file_exists(public_path('storage'))) {
    echo "  ✓ Storage link exists\n";
} else {
    echo "  ⚠️ Storage link NOT created. Run: php artisan storage:link\n";
}

// 6. Check routes
echo "\n✓ Checking critical routes...\n";

try {
    $routes = \Illuminate\Support\Facades\Route::getRoutes();
    $criticalRoutes = [
        'home',
        'login',
        'register',
        'dashboard',
        'admin.login',
        'admin.dashboard',
    ];
    
    foreach ($criticalRoutes as $routeName) {
        if ($routes->hasNamedRoute($routeName)) {
            echo "  ✓ Route '$routeName' is registered\n";
        } else {
            echo "  ✗ Route '$routeName' is NOT registered!\n";
        }
    }
} catch (\Exception $e) {
    echo "  ✗ Error checking routes: " . $e->getMessage() . "\n";
}

// 7. Check config caching
echo "\n✓ Checking config cache status...\n";

if (file_exists(base_path('bootstrap/cache/config.php'))) {
    echo "  ⚠️ Config is cached. For production: OK, For development: Clear with 'php artisan config:clear'\n";
} else {
    echo "  ✓ Config is not cached (good for development)\n";
}

// 8. Check common errors
echo "\n✓ Checking for common errors...\n";

// Check duplicate migrations
$migrationFiles = glob(database_path('migrations/*.php'));
$migrationNames = array_map(function($file) {
    return basename($file);
}, $migrationFiles);

$duplicates = array_filter(array_count_values($migrationNames), function($count) {
    return $count > 1;
});

if (count($duplicates) > 0) {
    echo "  ⚠️ WARNING: Duplicate migration files detected:\n";
    foreach ($duplicates as $name => $count) {
        echo "    - $name ($count times)\n";
    }
} else {
    echo "  ✓ No duplicate migrations\n";
}

// Check for empty migration files
$emptyMigrations = [];
foreach ($migrationFiles as $file) {
    if (strpos(basename($file), 'add_items_and_confirmed_to_orders_table') !== false) {
        $content = file_get_contents($file);
        if (strpos($content, '//') !== false && 
            preg_match('/function up.*?{\s*Schema::table.*?{\s*\/\/\s*}\s*}\s*}/s', $content)) {
            $emptyMigrations[] = basename($file);
        }
    }
}

if (count($emptyMigrations) > 0) {
    echo "  ⚠️ WARNING: Empty migration files detected (safe to delete):\n";
    foreach ($emptyMigrations as $name) {
        echo "    - $name\n";
    }
} else {
    echo "  ✓ No empty migrations detected\n";
}

echo "\n=== HOSTING READINESS CHECK COMPLETE ===\n";
echo "\n📋 RECOMMENDATIONS FOR HOSTING:\n";
echo "1. Set APP_ENV=production in .env\n";
echo "2. Set APP_DEBUG=false in .env\n";
echo "3. Run: php artisan config:cache\n";
echo "4. Run: php artisan route:cache\n";
echo "5. Run: php artisan view:cache\n";
echo "6. Ensure storage and bootstrap/cache are writable (chmod 775)\n";
echo "7. Point web server to /public directory\n";
echo "8. Enable mod_rewrite for Apache\n";
echo "9. Set proper database credentials\n";
echo "10. Run: php artisan migrate --force (in production)\n\n";
