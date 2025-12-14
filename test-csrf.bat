@echo off
title Quick Test - Laravel Server
cls
echo ============================================================
echo              QUICK TEST - CSRF dan Session
echo ============================================================
echo.
echo Testing Laravel configuration...
echo.

echo [1/4] Checking if server is running...
curl -s -o nul -w "HTTP Status: %%{http_code}\n" http://127.0.0.1:8000/login
if errorlevel 1 (
    echo ERROR: Server tidak berjalan!
    echo Silakan jalankan: php artisan serve
    echo.
    pause
    exit /b 1
)

echo.
echo [2/4] Testing CSRF token generation...
curl -s http://127.0.0.1:8000/login | findstr "_token" >nul
if errorlevel 1 (
    echo WARNING: CSRF token tidak ditemukan!
) else (
    echo OK: CSRF token ada di halaman
)

echo.
echo [3/4] Checking session configuration...
php artisan tinker --execute="echo 'Session driver: ' . config('session.driver');"

echo.
echo [4/4] Checking .env file...
findstr /C:"APP_URL=" .env
findstr /C:"SESSION_DRIVER=" .env

echo.
echo ============================================================
echo                    TEST SELESAI
echo ============================================================
echo.
echo LANGKAH SELANJUTNYA:
echo 1. Pastikan server running di http://127.0.0.1:8000
echo 2. Buka browser INCOGNITO mode
echo 3. Akses: http://127.0.0.1:8000/login
echo 4. Cek browser console (F12) untuk error
echo.
echo Jika masih error, jalankan: fix-csrf-error.bat
echo.
pause
