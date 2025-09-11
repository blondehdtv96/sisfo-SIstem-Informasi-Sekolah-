<?php
// Test matapelajaran controller directly (bypassing auth for testing)
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/matapelajaran';

// Mock session data for testing
$_SESSION['logged_in'] = true;
$_SESSION['id_level_user'] = 1; // Admin level
$_SESSION['user_type'] = 'user';
$_SESSION['username'] = 'admin';
$_SESSION['nama_lengkap'] = 'Test Admin';

// Change directory to the CI application root
chdir('c:/xampp/htdocs/sisfo');

// Load CodeIgniter index file to bootstrap the framework
ob_start();

// Set the environment
define('ENVIRONMENT', isset($_SERVER['CI_ENV']) ? $_SERVER['CI_ENV'] : 'development');

// Include the main index file
include 'index.php';

$output = ob_get_contents();
ob_end_clean();

echo "Testing Matapelajaran Controller (with mocked session)...\n";
echo "Output length: " . strlen($output) . " characters\n";

// Check for mata pelajaran content
if (strpos($output, 'mata pelajaran') !== false || strpos($output, 'Mata Pelajaran') !== false) {
    echo "✅ SUCCESS: Page contains mata pelajaran content\n";
} else {
    echo "❌ ERROR: Page doesn't contain mata pelajaran content\n";
}

// Check for database content
if (strpos($output, 'B.IND') !== false || strpos($output, 'Bahasa Indonesia') !== false) {
    echo "✅ SUCCESS: Page contains database content\n";
} else {
    echo "❌ ERROR: Page doesn't contain database content\n";
}

// Save the output for inspection
file_put_contents('matapelajaran_direct_test.html', $output);
echo "Output saved to matapelajaran_direct_test.html\n";

// Show first part of output
echo "\nFirst 500 characters:\n";
echo substr($output, 0, 500) . "...\n";
?>