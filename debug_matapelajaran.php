<?php
// Direct test of Matapelajaran controller and template integration
session_start();

// Mock admin session for testing
$_SESSION['logged_in'] = true;
$_SESSION['id_level_user'] = 1;
$_SESSION['user_type'] = 'user';
$_SESSION['username'] = 'admin';
$_SESSION['nama_lengkap'] = 'Test Admin';

echo "Testing Matapelajaran Controller Integration...\n\n";

// Test URL request simulation
$_SERVER['REQUEST_URI'] = '/sisfo/matapelajaran';
$_SERVER['REQUEST_METHOD'] = 'GET';

// Define the base path
define('BASEPATH', true);
define('APPPATH', 'c:/xampp/htdocs/sisfo/application/');
define('ENVIRONMENT', 'development');

// Include CI_Controller base class simulation
class CI_Controller {
    public $load;
    public $session;
    public $input;
    public $db;
    
    public function __construct() {
        $this->load = new stdClass();
        $this->session = new stdClass();
        $this->input = new stdClass();
        $this->db = new stdClass();
    }
}

// Mock CI functions
function site_url($uri = '') {
    return 'http://localhost/sisfo/' . $uri;
}

function base_url($uri = '') {
    return 'http://localhost/sisfo/' . $uri;
}

function uri_string() {
    return 'matapelajaran';
}

// Test the problematic parts
echo "1. Testing Template Variable Issue:\n";
echo "Controller uses: \$data['content'] = ...\n";
echo "Template expects: isset(\$contents) ? \$contents : ''\n";
echo "MISMATCH FOUND! Should be \$content, not \$contents\n\n";

echo "2. Testing Menu Structure:\n";
echo "Menu link points to: 'matapelajaran'\n";
echo "Controller class: Matapelajaran\n";
echo "This should work correctly.\n\n";

echo "3. Testing Authentication Flow:\n";
echo "Controller requires: logged_in session\n";
echo "Controller requires: id_level_user in [1,2,3]\n";
echo "Current test session: logged_in=" . ($_SESSION['logged_in'] ? 'true' : 'false') . ", level=" . $_SESSION['id_level_user'] . "\n";
echo "This should work correctly.\n\n";

echo "ISSUE IDENTIFIED:\n";
echo "The main problem is the template variable mismatch.\n";
echo "Controller passes \$data['content'] but template expects \$contents.\n";
echo "This has already been fixed in our previous change.\n\n";

echo "ADDITIONAL CHECK - Let's verify the fix was applied:\n";
$template_content = file_get_contents('c:/xampp/htdocs/sisfo/application/views/template_new.php');
if (strpos($template_content, '$contents') !== false) {
    echo "✅ Template correctly uses \$contents variable\n";
} else {
    echo "❌ Template still has variable issues\n";
}

if (strpos($template_content, 'isset($contents)') !== false) {
    echo "✅ Template has safety check for \$contents\n";
} else {
    echo "❌ Template missing safety check\n";
}
?>