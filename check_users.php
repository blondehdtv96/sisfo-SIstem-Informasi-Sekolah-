<?php
// Check if there are default users for testing
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'sisfo_smk_bina_mandiri';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Checking users in the database...\n\n";
    
    // Check tb_user table
    echo "=== Admin/User Accounts ===\n";
    $stmt = $pdo->query("SELECT id_user, username, nama_lengkap, id_level, status FROM tb_user");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($users)) {
        echo "No admin users found in tb_user table.\n";
    } else {
        foreach ($users as $user) {
            $level_name = '';
            switch($user['id_level']) {
                case 1: $level_name = 'Administrator'; break;
                case 2: $level_name = 'Wali Kelas'; break;
                case 3: $level_name = 'Guru'; break;
                case 4: $level_name = 'Siswa'; break;
            }
            echo "- Username: {$user['username']}, Name: {$user['nama_lengkap']}, Level: $level_name, Status: {$user['status']}\n";
        }
    }
    
    // Check tb_guru table
    echo "\n=== Teacher Accounts ===\n";
    $stmt = $pdo->query("SELECT id_guru, username, nama_guru, status FROM tb_guru WHERE username IS NOT NULL");
    $teachers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($teachers)) {
        echo "No teacher accounts found with username.\n";
    } else {
        foreach ($teachers as $teacher) {
            echo "- Username: {$teacher['username']}, Name: {$teacher['nama_guru']}, Status: {$teacher['status']}\n";
        }
    }
    
    // Check tb_siswa table for sample student accounts
    echo "\n=== Student Accounts (sample) ===\n";
    $stmt = $pdo->query("SELECT nisn, nama_siswa, status FROM tb_siswa LIMIT 3");
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($students)) {
        echo "No student accounts found.\n";
    } else {
        foreach ($students as $student) {
            echo "- NISN: {$student['nisn']}, Name: {$student['nama_siswa']}, Status: {$student['status']}\n";
        }
    }
    
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage() . "\n";
}
?>