<?php
// Test the fixed tingkatan controller
echo "Testing Fixed Tingkatan Controller...\n";

$url = 'http://localhost:8000/sisfo/tingkatan';
echo "Testing URL: $url\n";

// First, let's check if we can access the login page and get a session
$login_url = 'http://localhost:8000/sisfo/auth/login';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $login_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookies_tingkatan.txt');

// Prepare login data
$login_data = array(
    'username' => 'admin',
    'password' => 'admin123'
);

curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($login_data));

$login_response = curl_exec($ch);
$login_http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

curl_close($ch);

echo "Login attempt HTTP code: $login_http_code\n";

if ($login_http_code == 302 || $login_http_code == 200) {
    echo "✅ Login successful or redirected\n";
    
    // Now try to access tingkatan with the session
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookies_tingkatan.txt');
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $effectiveUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);

    curl_close($ch);

    echo "Tingkatan page HTTP Code: $httpCode\n";
    echo "Effective URL: $effectiveUrl\n";
    echo "Response length: " . strlen($response) . " characters\n";

    // Check for tingkatan content
    if (strpos($response, 'tingkatan') !== false || strpos($response, 'Tingkatan') !== false) {
        echo "✅ SUCCESS: Page contains tingkatan content\n";
    } else {
        echo "❌ ERROR: Page doesn't contain tingkatan content\n";
    }

    // Check for database content (grade levels)
    if (strpos($response, 'XI') !== false || strpos($response, 'XII') !== false) {
        echo "✅ SUCCESS: Page contains grade level data\n";
    } else {
        echo "❌ ERROR: Page doesn't contain grade level data\n";
    }

    // Check for table structure
    if (strpos($response, '<table') !== false && strpos($response, 'tingkatanTable') !== false) {
        echo "✅ SUCCESS: Page contains proper table structure\n";
    } else {
        echo "❌ ERROR: Page missing table structure\n";
    }

    // Check for statistics
    if (strpos($response, 'Total Tingkatan') !== false) {
        echo "✅ SUCCESS: Page contains statistics\n";
    } else {
        echo "❌ ERROR: Page missing statistics\n";
    }
    
    // Save response for debugging
    file_put_contents('tingkatan_fixed_test.html', $response);
    echo "Response saved to tingkatan_fixed_test.html\n";
    
} else {
    echo "❌ ERROR: Login failed with code $login_http_code\n";
}

// Clean up
@unlink('cookies_tingkatan.txt');
?>