<?php
// Simple test to check matapelajaran controller response
echo "Testing Matapelajaran Controller...\n";

// Test the URL
$url = 'http://localhost:8000/sisfo/matapelajaran';
echo "Testing URL: $url\n";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$effectiveUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);

curl_close($ch);

echo "HTTP Code: $httpCode\n";
echo "Effective URL: $effectiveUrl\n";
echo "Response length: " . strlen($response) . " characters\n";

// Check for common issues
if ($httpCode == 404) {
    echo "❌ ERROR: Page not found (404)\n";
    echo "This suggests the controller or route is not working.\n";
} elseif ($httpCode == 500) {
    echo "❌ ERROR: Internal server error (500)\n";
    echo "This suggests a PHP error in the application.\n";
} elseif ($httpCode == 200) {
    echo "✅ SUCCESS: Page loaded successfully\n";
    
    // Check if response contains expected content
    if (strpos($response, 'mata pelajaran') !== false || strpos($response, 'Mata Pelajaran') !== false) {
        echo "✅ SUCCESS: Page contains mata pelajaran content\n";
    } else {
        echo "⚠️  WARNING: Page loaded but doesn't contain expected content\n";
    }
    
    // Check for Bootstrap or CSS
    if (strpos($response, 'bootstrap') !== false || strpos($response, 'table') !== false) {
        echo "✅ SUCCESS: Page appears to have proper styling\n";
    } else {
        echo "⚠️  WARNING: Page may be missing styling\n";
    }
    
    // Check for data
    if (strpos($response, 'B.IND') !== false || strpos($response, 'Bahasa Indonesia') !== false) {
        echo "✅ SUCCESS: Page contains actual data from database\n";
    } else {
        echo "❌ ERROR: Page doesn't contain expected database content\n";
        echo "First 500 characters of response:\n";
        echo substr($response, 0, 500) . "...\n";
    }
} else {
    echo "❓ UNKNOWN: Unexpected HTTP code\n";
}

// Save response for debugging
file_put_contents('matapelajaran_response.html', $response);
echo "\nResponse saved to matapelajaran_response.html for debugging\n";
?>