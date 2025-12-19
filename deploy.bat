@echo off
REM ============================================
REM Laravel Production Deployment Script (Windows)
REM ============================================

echo.
echo ======================================================
echo    Laravel Production Deployment Script
echo ======================================================
echo.

REM 1. Check if .env exists
if not exist .env (
    echo [ERROR] .env file not found!
    echo [INFO] Creating .env from .env.example...
    copy .env.example .env
    echo [SUCCESS] .env created. Please edit it with production credentials!
    echo.
)

REM 2. Install Composer dependencies
echo [STEP] Installing Composer dependencies...
composer install --optimize-autoloader --no-dev
if %errorlevel% neq 0 (
    echo [WARNING] Composer install failed. Please check manually.
) else (
    echo [SUCCESS] Composer dependencies installed
)
echo.

REM 3. Generate APP_KEY if not set
echo [STEP] Checking APP_KEY...
findstr /C:"APP_KEY=" .env | findstr /C:"APP_KEY=$" > nul
if %errorlevel% equ 0 (
    echo [INFO] Generating APP_KEY...
    php artisan key:generate
    echo [SUCCESS] APP_KEY generated
) else (
    echo [SUCCESS] APP_KEY already set
)
echo.

REM 4. Clear all caches
echo [STEP] Clearing all caches...
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
echo [SUCCESS] Caches cleared
echo.

REM 5. Run migrations
echo [STEP] Database migrations...
set /p migrate="Run migrations? This will modify your database (y/N): "
if /i "%migrate%"=="y" (
    php artisan migrate --force
    echo [SUCCESS] Migrations completed
) else (
    echo [INFO] Skipped migrations
)
echo.

REM 6. Create storage link
echo [STEP] Creating storage link...
php artisan storage:link
echo [SUCCESS] Storage link created
echo.

REM 7. Cache for production
echo [STEP] Caching for production...
php artisan config:cache
php artisan route:cache
php artisan view:cache
echo [SUCCESS] Production caches created
echo.

REM 8. Optimize autoloader
echo [STEP] Optimizing autoloader...
composer dump-autoload --optimize
echo [SUCCESS] Autoloader optimized
echo.

REM 9. Check critical directories
echo [STEP] Checking critical directories...
if not exist storage\framework\sessions mkdir storage\framework\sessions
if not exist storage\framework\views mkdir storage\framework\views
if not exist storage\framework\cache mkdir storage\framework\cache
if not exist storage\logs mkdir storage\logs
if not exist public\images\products mkdir public\images\products
echo [SUCCESS] Critical directories checked
echo.

REM 10. Final checks
echo [STEP] Running final checks...
php artisan about
echo.

echo ======================================================
echo    Deployment Complete!
echo ======================================================
echo.
echo [NEXT STEPS]
echo 1. Edit .env with production credentials
echo 2. Set APP_ENV=production
echo 3. Set APP_DEBUG=false
echo 4. Configure database credentials
echo 5. Point web server document root to /public
echo 6. Enable HTTPS (SSL certificate)
echo 7. Test all features
echo.
echo [TROUBLESHOOTING]
echo If you encounter issues, check:
echo - storage\logs\laravel.log
echo - Web server error logs
echo - PHP error logs
echo.
pause
