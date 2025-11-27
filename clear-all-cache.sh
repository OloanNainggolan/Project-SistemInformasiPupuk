#!/bin/bash

echo "========================================"
echo "CLEARING ALL LARAVEL CACHE"
echo "========================================"
echo ""

echo "[1/6] Clearing application cache..."
php artisan cache:clear

echo ""
echo "[2/6] Clearing route cache..."
php artisan route:clear

echo ""
echo "[3/6] Clearing config cache..."
php artisan config:clear

echo ""
echo "[4/6] Clearing compiled views..."
php artisan view:clear

echo ""
echo "[5/6] Clearing compiled classes..."
php artisan clear-compiled

echo ""
echo "[6/6] Optimizing autoloader..."
composer dump-autoload

echo ""
echo "========================================"
echo "ALL CACHE CLEARED SUCCESSFULLY!"
echo "========================================"
echo ""
echo "Now run: php artisan serve"
echo ""
