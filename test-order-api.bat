@echo off
echo Testing Order API Endpoint...
echo.

REM Test dengan curl
curl -X POST "http://127.0.0.1:8000/user/pupuk-bibit/1/simpan-pesanan" ^
  -H "Content-Type: application/json" ^
  -H "Accept: application/json" ^
  -H "X-CSRF-TOKEN: test-token" ^
  -d "{\"quantity\":1,\"customer_name\":\"Test User\",\"customer_phone\":\"08123456789\",\"customer_address\":\"Test Address\",\"customer_notes\":\"Test notes\"}"

echo.
echo.
echo Test completed!
pause
