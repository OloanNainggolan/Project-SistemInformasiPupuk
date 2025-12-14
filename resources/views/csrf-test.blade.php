<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CSRF Debug Test</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .container {
            background: white;
            border-radius: 20px;
            padding: 40px;
            max-width: 600px;
            width: 100%;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }
        .info-box {
            background: #f0f9ff;
            border: 2px solid #0ea5e9;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .info-box h3 {
            color: #0369a1;
            margin-bottom: 15px;
        }
        .info-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #e0f2fe;
        }
        .info-item:last-child {
            border-bottom: none;
        }
        .label {
            font-weight: 600;
            color: #555;
        }
        .value {
            color: #0369a1;
            font-family: monospace;
            word-break: break-all;
        }
        .test-form {
            background: #fef3c7;
            border: 2px solid #f59e0b;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
        }
        .test-form h3 {
            color: #92400e;
            margin-bottom: 15px;
        }
        input[type="text"] {
            width: 100%;
            padding: 12px;
            border: 2px solid #fbbf24;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 15px;
        }
        button {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s;
        }
        button:hover {
            transform: translateY(-2px);
        }
        .success {
            background: #d1fae5;
            border: 2px solid #10b981;
            color: #065f46;
            padding: 15px;
            border-radius: 10px;
            margin-top: 15px;
            display: none;
        }
        .error {
            background: #fee2e2;
            border: 2px solid #ef4444;
            color: #991b1b;
            padding: 15px;
            border-radius: 10px;
            margin-top: 15px;
            display: none;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔍 CSRF Debug & Test</h1>
        
        <div class="info-box">
            <h3>📊 Session & CSRF Info</h3>
            <div class="info-item">
                <span class="label">CSRF Token:</span>
                <span class="value" id="csrfTokenDisplay">{{ csrf_token() }}</span>
            </div>
            <div class="info-item">
                <span class="label">Session ID:</span>
                <span class="value">{{ session()->getId() }}</span>
            </div>
            <div class="info-item">
                <span class="label">Session Driver:</span>
                <span class="value">{{ config('session.driver') }}</span>
            </div>
            <div class="info-item">
                <span class="label">Session Lifetime:</span>
                <span class="value">{{ config('session.lifetime') }} minutes</span>
            </div>
            <div class="info-item">
                <span class="label">Current URL:</span>
                <span class="value">{{ url()->current() }}</span>
            </div>
            <div class="info-item">
                <span class="label">APP_URL:</span>
                <span class="value">{{ config('app.url') }}</span>
            </div>
        </div>

        <div class="test-form">
            <h3>🧪 Test Form Submit</h3>
            <form method="POST" action="{{ route('csrf.test.submit') }}" id="testForm">
                @csrf
                <input type="text" name="test_data" placeholder="Ketik apa saja untuk test..." required>
                <button type="submit">Test Submit Form</button>
            </form>
            
            <div class="success" id="successMsg">
                ✅ Form berhasil di-submit! CSRF token valid.
            </div>
            
            <div class="error" id="errorMsg">
                ❌ Error: <span id="errorText"></span>
            </div>
        </div>

        <a href="{{ route('login') }}" class="back-link">← Kembali ke Login</a>
    </div>

    <script>
        // Auto-update CSRF token display setiap 5 detik
        setInterval(function() {
            const token = document.querySelector('meta[name="csrf-token"]')?.content;
            if (token) {
                document.getElementById('csrfTokenDisplay').textContent = token;
            }
        }, 5000);

        // Handle form submit dengan AJAX untuk test
        document.getElementById('testForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const successMsg = document.getElementById('successMsg');
            const errorMsg = document.getElementById('errorMsg');
            const errorText = document.getElementById('errorText');
            
            // Hide previous messages
            successMsg.style.display = 'none';
            errorMsg.style.display = 'none';
            
            fetch(this.action, {
                method: 'POST',
                body: formData,
                credentials: 'same-origin',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => {
                if (response.ok) {
                    return response.json();
                }
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            })
            .then(data => {
                successMsg.style.display = 'block';
                successMsg.innerHTML = '✅ ' + (data.message || 'Form berhasil di-submit! CSRF token valid.');
            })
            .catch(error => {
                errorMsg.style.display = 'block';
                errorText.textContent = error.message;
            });
        });

        // Log info ke console
        console.log('CSRF Token:', document.querySelector('meta[name="csrf-token"]')?.content);
        console.log('Session Driver:', '{{ config("session.driver") }}');
        console.log('Page URL:', window.location.href);
    </script>
</body>
</html>
