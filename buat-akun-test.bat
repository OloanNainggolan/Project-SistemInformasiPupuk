@echo off
echo ================================================
echo   BUAT AKUN TEST BARU
echo ================================================
echo.
php create_test_user.php
echo.
echo ================================================
echo   VERIFIKASI AKUN
echo ================================================
echo.
php verify_demo_account.php
echo.
pause
