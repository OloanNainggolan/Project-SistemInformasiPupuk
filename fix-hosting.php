<?php
/**
 * Laravel Hosting Fix - Diagnose & Fix 403 Error
 * Upload file ini ke ROOT hosting dan akses via browser
 * URL: http://pupuk2bibit.std1.tech/fix-hosting.php
 */

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Laravel Hosting Fix</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
        .container { max-width: 900px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #e74c3c; margin-bottom: 30px; }
        .check { padding: 15px; margin: 10px 0; border-radius: 5px; }
        .ok { background: #d4edda; color: #155724; border-left: 4px solid #28a745; }
        .error { background: #f8d7da; color: #721c24; border-left: 4px solid #dc3545; }
        .warning { background: #fff3cd; color: #856404; border-left: 4px solid #ffc107; }
        .info { background: #d1ecf1; color: #0c5460; border-left: 4px solid #17a2b8; }
        .fix-btn { background: #28a745; color: white; padding: 12px 30px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; margin-top: 20px; }
        .fix-btn:hover { background: #218838; }
        pre { background: #f8f9fa; padding: 15px; border-radius: 5px; overflow-x: auto; }
        code { color: #e83e8c; }
    </style>
</head>
<body>
<div class="container">
    <h1>🔧 Laravel Hosting Diagnostic Tool</h1>
    
<?php

// Auto-fix jika ada parameter
if (isset($_GET['fix'])) {
    echo "<h2>🔨 Running Auto-Fix...</h2>";
    
    $fixed = [];
    $errors = [];
    
    // Fix storage permissions
    if (is_dir('storage')) {
        if (chmod_recursive('storage', 0775)) {
            $fixed[] = "✅ Storage permissions fixed to 775";
        } else {
            $errors[] = "❌ Failed to fix storage permissions";
        }
    }
    
    // Fix bootstrap/cache permissions
    if (is_dir('bootstrap/cache')) {
        if (chmod_recursive('bootstrap/cache', 0775)) {
            $fixed[] = "✅ Bootstrap/cache permissions fixed to 775";
        } else {
            $errors[] = "❌ Failed to fix bootstrap/cache permissions";
        }
    }
    
    // Create .htaccess di root jika belum ada
    if (!file_exists('.htaccess')) {
        $htaccess_content = '<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>';
        if (file_put_contents('.htaccess', $htaccess_content)) {
            $fixed[] = "✅ .htaccess created in root folder";
        } else {
            $errors[] = "❌ Failed to create .htaccess";
        }
    }
    
    // Clear cache files jika bisa
    $cache_dirs = [
        'storage/framework/cache' => 'Cache',
        'storage/framework/views' => 'Views',
        'storage/framework/sessions' => 'Sessions',
        'bootstrap/cache' => 'Bootstrap'
    ];
    
    foreach ($cache_dirs as $dir => $name) {
        if (is_dir($dir)) {
            $count = clear_directory($dir);
            $fixed[] = "✅ Cleared $count files from $name cache";
        }
    }
    
    echo "<div class='check ok'>";
    echo "<h3>Fixed Items:</h3>";
    foreach ($fixed as $item) {
        echo "<div>$item</div>";
    }
    echo "</div>";
    
    if (!empty($errors)) {
        echo "<div class='check error'>";
        echo "<h3>Errors:</h3>";
        foreach ($errors as $item) {
            echo "<div>$item</div>";
        }
        echo "</div>";
    }
    
    echo "<div class='check info'><strong>✅ Auto-fix completed! Refresh this page to see updated diagnostics.</strong></div>";
    echo "<br><a href='fix-hosting.php' style='padding: 10px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 5px;'>Run Diagnostics Again</a>";
    echo "</div></body></html>";
    exit;
}

// ===== DIAGNOSTICS =====

echo "<h2>📊 Current Status:</h2>";

$issues = 0;
$warnings = 0;

// 1. Check PHP Version
echo "<div class='check " . (PHP_VERSION_ID >= 80200 ? "ok" : "error") . "'>";
echo "<strong>PHP Version:</strong> " . PHP_VERSION;
if (PHP_VERSION_ID < 80200) {
    echo " ❌ Laravel 12 requires PHP 8.2+";
    $issues++;
} else {
    echo " ✅ OK";
}
echo "</div>";

// 2. Check document root
$doc_root = $_SERVER['DOCUMENT_ROOT'];
$is_public = (strpos($doc_root, '/public') !== false || strpos($doc_root, '\\public') !== false);
echo "<div class='check " . ($is_public ? "ok" : "error") . "'>";
echo "<strong>Document Root:</strong> <code>$doc_root</code>";
if (!$is_public) {
    echo "<br>❌ Document root should point to <code>/public</code> folder!";
    echo "<br>📝 Change in cPanel: <strong>Domains → Document Root → /home/pupukbib/public</strong>";
    $issues++;
} else {
    echo " ✅ OK";
}
echo "</div>";

// 3. Check .htaccess di root
$root_htaccess = __DIR__ . '/.htaccess';
echo "<div class='check " . (file_exists($root_htaccess) ? "ok" : "warning") . "'>";
echo "<strong>Root .htaccess:</strong> ";
if (file_exists($root_htaccess)) {
    echo "✅ Exists";
} else {
    echo "⚠️ Not found (needed if Document Root is not /public)";
    $warnings++;
}
echo "</div>";

// 4. Check .env file
echo "<div class='check " . (file_exists('.env') ? "ok" : "error") . "'>";
echo "<strong>.env File:</strong> ";
if (file_exists('.env')) {
    echo "✅ Exists";
    $env_content = file_get_contents('.env');
    if (strpos($env_content, 'APP_ENV=production') === false) {
        echo "<br>⚠️ Set <code>APP_ENV=production</code> for hosting";
        $warnings++;
    }
} else {
    echo "❌ Missing! Copy from .env.example";
    $issues++;
}
echo "</div>";

// 5. Check storage permissions
$storage_perm = is_dir('storage') ? substr(sprintf('%o', fileperms('storage')), -3) : '000';
echo "<div class='check " . ($storage_perm >= '775' ? "ok" : "error") . "'>";
echo "<strong>Storage Permissions:</strong> <code>$storage_perm</code>";
if ($storage_perm < '775') {
    echo " ❌ Should be 775 or 777";
    $issues++;
} else {
    echo " ✅ OK";
}
echo "</div>";

// 6. Check bootstrap/cache permissions
$cache_perm = is_dir('bootstrap/cache') ? substr(sprintf('%o', fileperms('bootstrap/cache')), -3) : '000';
echo "<div class='check " . ($cache_perm >= '775' ? "ok" : "error") . "'>";
echo "<strong>Bootstrap/Cache Permissions:</strong> <code>$cache_perm</code>";
if ($cache_perm < '775') {
    echo " ❌ Should be 775 or 777";
    $issues++;
} else {
    echo " ✅ OK";
}
echo "</div>";

// 7. Check storage subdirectories
$storage_dirs = ['app', 'framework', 'logs'];
foreach ($storage_dirs as $dir) {
    $path = "storage/$dir";
    if (is_dir($path)) {
        $perm = substr(sprintf('%o', fileperms($path)), -3);
        $writable = is_writable($path);
        echo "<div class='check " . ($writable ? "ok" : "error") . "'>";
        echo "<strong>storage/$dir:</strong> <code>$perm</code> " . ($writable ? "✅ Writable" : "❌ Not writable");
        echo "</div>";
        if (!$writable) $issues++;
    }
}

// 8. Check public folder
echo "<div class='check " . (is_dir('public') ? "ok" : "error") . "'>";
echo "<strong>Public Folder:</strong> ";
if (is_dir('public')) {
    echo "✅ Exists";
    if (file_exists('public/index.php')) {
        echo " | <code>index.php</code> ✅";
    } else {
        echo " | <code>index.php</code> ❌ Missing!";
        $issues++;
    }
} else {
    echo "❌ Missing!";
    $issues++;
}
echo "</div>";

// 9. Check vendor folder
echo "<div class='check " . (is_dir('vendor') ? "ok" : "error") . "'>";
echo "<strong>Vendor Dependencies:</strong> ";
if (is_dir('vendor')) {
    echo "✅ Installed";
} else {
    echo "❌ Missing! Run <code>composer install</code>";
    $issues++;
}
echo "</div>";

// Summary
echo "<hr>";
if ($issues == 0 && $warnings == 0) {
    echo "<div class='check ok'>";
    echo "<h3>✅ All checks passed!</h3>";
    echo "<p>If you still see 403 error, try:</p>";
    echo "<ul>";
    echo "<li>Restart web server in cPanel</li>";
    echo "<li>Check .htaccess in public/ folder</li>";
    echo "<li>Check Apache error logs</li>";
    echo "</ul>";
    echo "</div>";
} else {
    echo "<div class='check error'>";
    echo "<h3>Found $issues critical issues and $warnings warnings</h3>";
    echo "<p>Click button below to auto-fix common issues:</p>";
    echo "<form method='get'>";
    echo "<button type='submit' name='fix' value='1' class='fix-btn'>🔧 Run Auto-Fix</button>";
    echo "</form>";
    echo "</div>";
}

// Helper functions
function chmod_recursive($path, $perm) {
    if (!is_dir($path)) return false;
    
    $result = @chmod($path, $perm);
    
    $items = @scandir($path);
    if ($items === false) return $result;
    
    foreach ($items as $item) {
        if ($item == '.' || $item == '..') continue;
        
        $fullpath = $path . '/' . $item;
        if (is_dir($fullpath)) {
            chmod_recursive($fullpath, $perm);
        } else {
            @chmod($fullpath, 0664);
        }
    }
    
    return $result;
}

function clear_directory($path) {
    if (!is_dir($path)) return 0;
    
    $count = 0;
    $items = @scandir($path);
    if ($items === false) return 0;
    
    foreach ($items as $item) {
        if ($item == '.' || $item == '..' || $item == '.gitignore') continue;
        
        $fullpath = $path . '/' . $item;
        if (is_file($fullpath)) {
            if (@unlink($fullpath)) $count++;
        } elseif (is_dir($fullpath)) {
            $count += clear_directory($fullpath);
            @rmdir($fullpath);
        }
    }
    
    return $count;
}

?>

<hr>
<div class='check info'>
    <strong>📝 Manual Steps if Auto-Fix doesn't work:</strong>
    <pre>
# Via SSH Terminal:
cd /home/pupukbib
chmod -R 775 storage bootstrap/cache
php artisan config:clear
php artisan cache:clear
php artisan optimize

# Set Document Root in cPanel:
Domains → pupuk2bibit.std1.tech → Document Root → /home/pupukbib/public
    </pre>
</div>

<div style='margin-top: 30px; padding: 15px; background: #e9ecef; border-radius: 5px; font-size: 12px;'>
    <strong>Debug Info:</strong><br>
    Current File Location: <code><?php echo __FILE__; ?></code><br>
    Script Directory: <code><?php echo __DIR__; ?></code><br>
    Document Root: <code><?php echo $_SERVER['DOCUMENT_ROOT']; ?></code><br>
    Request URI: <code><?php echo $_SERVER['REQUEST_URI']; ?></code>
</div>

</div>
</body>
</html>
