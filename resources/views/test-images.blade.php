<!DOCTYPE html>
<html>
<head>
    <title>Image Test</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        .test-section { margin: 20px 0; padding: 15px; border: 1px solid #ddd; }
        img { max-width: 300px; margin: 10px; border: 2px solid #10b981; }
        .error { color: red; }
        .success { color: green; }
    </style>
</head>
<body>
    <h1>Image Display Test</h1>
    
    <div class="test-section">
        <h3>Test 1: Direct Path</h3>
        <img src="/images/products/1764648329_692e65890ba3d_0.jpg" alt="Test 1" 
             onload="document.getElementById('test1').innerHTML = '✓ Loaded'" 
             onerror="document.getElementById('test1').innerHTML = '✗ Failed'">
        <div id="test1">Loading...</div>
    </div>

    <div class="test-section">
        <h3>Test 2: Using asset() helper</h3>
        <img src="{{ asset('images/products/1764648329_692e65890ba3d_0.jpg') }}" alt="Test 2"
             onload="document.getElementById('test2').innerHTML = '✓ Loaded'" 
             onerror="document.getElementById('test2').innerHTML = '✗ Failed'">
        <div id="test2">Loading...</div>
        <p>URL: {{ asset('images/products/1764648329_692e65890ba3d_0.jpg') }}</p>
    </div>

    <div class="test-section">
        <h3>Test 3: Placeholder</h3>
        <img src="{{ asset('images/products/placeholder.jpg') }}" alt="Test 3"
             onload="document.getElementById('test3').innerHTML = '✓ Loaded'" 
             onerror="document.getElementById('test3').innerHTML = '✗ Failed'">
        <div id="test3">Loading...</div>
    </div>

    <div class="test-section">
        <h3>Test 4: Check from Database</h3>
        @php
            $testProduct = \App\Models\Product::with('primaryImage')->first();
        @endphp
        @if($testProduct && $testProduct->primaryImage)
            <p><strong>Product:</strong> {{ $testProduct->nama_produk }}</p>
            <p><strong>Image Path from DB:</strong> {{ $testProduct->primaryImage->image_path }}</p>
            <p><strong>Full URL:</strong> {{ asset($testProduct->primaryImage->image_path) }}</p>
            <img src="{{ asset($testProduct->primaryImage->image_path) }}" alt="{{ $testProduct->nama_produk }}"
                 onload="document.getElementById('test4').innerHTML = '✓ Loaded'" 
                 onerror="document.getElementById('test4').innerHTML = '✗ Failed: ' + this.src">
            <div id="test4">Loading...</div>
        @else
            <p class="error">No product with image found</p>
        @endif
    </div>

    <div class="test-section">
        <h3>File System Check</h3>
        @php
            $imagePath = public_path('images/products/1764648329_692e65890ba3d_0.jpg');
            $fileExists = file_exists($imagePath);
        @endphp
        <p><strong>File exists:</strong> {{ $fileExists ? 'YES ✓' : 'NO ✗' }}</p>
        <p><strong>Path:</strong> {{ $imagePath }}</p>
        @if($fileExists)
            <p><strong>File size:</strong> {{ number_format(filesize($imagePath)) }} bytes</p>
        @endif
    </div>
</body>
</html>
