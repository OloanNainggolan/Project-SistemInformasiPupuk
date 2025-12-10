@echo off
REM Test script untuk verifikasi endpoint order detail

echo Testing order detail API endpoint...
echo.

REM Menggunakan curl untuk test
curl -X GET "http://127.0.0.1:8000/user/orders/1/detail" ^
  -H "Content-Type: application/json" ^
  -H "Accept: application/json"

echo.
echo.
echo Testing profil endpoint...
curl -X GET "http://127.0.0.1:8000/profil" ^
  -H "Content-Type: text/html"

pause
