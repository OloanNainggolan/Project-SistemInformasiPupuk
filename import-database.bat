@echo off
echo ========================================
echo   Import Database - Pupuk dan Bibit
echo ========================================
echo.

cd C:\laragon\bin\mysql\mysql-8.0.30-winx64\bin

echo Mengimport database...
mysql -u root -e "CREATE DATABASE IF NOT EXISTS sistem_informasi_pupukdanbibit DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
mysql -u root sistem_informasi_pupukdanbibit < "C:\Users\LENOVO\Downloads\sistem_informasi_pupukdanbibit.sql"

echo.
if %ERRORLEVEL% == 0 (
    echo [SUCCESS] Database berhasil diimport!
    echo.
    echo Database: sistem_informasi_pupukdanbibit
    echo User: root
    echo Password: [kosong]
) else (
    echo [ERROR] Import database gagal!
    echo Cek path file SQL dan pastikan MySQL running.
)

echo.
pause
