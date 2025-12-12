<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Test API Nearest Pickup</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
        }
        .result {
            background: #f0f0f0;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
        }
        .success {
            background: #d4edda;
            color: #155724;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
        }
        button {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
        }
        button:hover {
            background: #45a049;
        }
        #loading {
            display: none;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h1>🧪 Test API Nearest Pickup</h1>
    <p>Klik tombol untuk test API endpoint /api/nearest-pickup</p>
    
    <button onclick="testAPI()">🚀 Test API</button>
    
    <div id="loading">
        <p>⏳ Loading...</p>
    </div>
    
    <div id="result"></div>

    <script>
        async function testAPI() {
            const resultDiv = document.getElementById('result');
            const loading = document.getElementById('loading');
            
            loading.style.display = 'block';
            resultDiv.innerHTML = '';
            
            // Test coordinates: Laguboti area
            const lat = 2.614;
            const lng = 99.071;
            
            try {
                const response = await fetch('/api/nearest-pickup', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ lat, lng })
                });
                
                loading.style.display = 'none';
                
                const data = await response.json();
                
                if (response.ok && data.nearest_location) {
                    const nearest = data.nearest_location;
                    resultDiv.className = 'result success';
                    resultDiv.innerHTML = `
                        <h3>✅ API Berhasil!</h3>
                        <p><strong>Status:</strong> ${response.status} OK</p>
                        <p><strong>Pickup Point Terdekat:</strong> ${nearest.name}</p>
                        <p><strong>Alamat:</strong> ${nearest.address}</p>
                        <p><strong>Jarak:</strong> ${nearest.distance.toFixed(2)} km</p>
                        <p><strong>Koordinat:</strong> ${nearest.latitude}, ${nearest.longitude}</p>
                    `;
                } else {
                    resultDiv.className = 'result error';
                    resultDiv.innerHTML = `
                        <h3>❌ API Error</h3>
                        <p><strong>Status:</strong> ${response.status}</p>
                        <p><strong>Response:</strong></p>
                        <pre>${JSON.stringify(data, null, 2)}</pre>
                    `;
                }
            } catch (error) {
                loading.style.display = 'none';
                resultDiv.className = 'result error';
                resultDiv.innerHTML = `
                    <h3>❌ JavaScript Error</h3>
                    <p><strong>Error:</strong> ${error.message}</p>
                `;
            }
        }
    </script>
</body>
</html>
