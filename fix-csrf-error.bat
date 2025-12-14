@echo off
cls
echo ============================================================
echo        FIX CSRF Token / Page Expired Error - LENGKAP
echo ============================================================
echo.
echo Langkah ini akan membersihkan semua cache dan session...
echo.
pause

echo.
echo [1/6] Optimizing and clearing all Laravel caches...
call php artisan optimize:clear

echo.
echo [2/6] Clearing session files from storage...
if exist "storage\framework\sessions\*" (
    del /Q "storage\framework\sessions\*"
    echo Session files deleted successfully!
) else (
    echo No session files to clear
)

echo.
echo [3/6] Clearing sessions from database (if using DB driver)...
call php artisan tinker --execute="try { DB::table('sessions')->truncate(); echo 'Database sessions cleared'; } catch (Exception $e) { echo 'Skipped: ' . $e->getMessage(); }"

echo.
echo [4/6] Clearing bootstrap cache...
if exist "bootstrap\cache\*.*" (
    del /Q "bootstrap\cache\*.php" 2>nul
    echo Bootstrap cache cleared!
)

echo.
echo [5/6] Regenerating config cache...
call php artisan config:cache

echo.
echo [6/6] Starting fresh Laravel server...
echo.
echo ============================================================
echo                   ✓ SEMUA SELESAI!
echo ============================================================
echo.
echo INSTRUKSI PENTING:
echo 1. Buka browser BARU atau mode Incognito/Private
echo 2. Akses: http://127.0.0.1:8000/login
echo 3. Jika masih error, tekan Ctrl+Shift+Delete hapus cookies
echo 4. Refresh dengan Ctrl+F5 (hard refresh)
echo.
echo Server akan dimulai sekarang...
echo Tekan Ctrl+C untuk stop server
echo.
pause
cls
php artisan serve
