<?php
// Test database connection and check mata pelajaran data
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'sisfo_smk_bina_mandiri';

try {
    $pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Database connection: OK\n";
    
    // Check if database exists
    $stmt = $pdo->query("SHOW DATABASES LIKE '$database'");
    if ($stmt->rowCount() == 0) {
        echo "Database '$database' does not exist. Creating...\n";
        $pdo->exec("CREATE DATABASE `$database` CHARACTER SET utf8 COLLATE utf8_general_ci");
        echo "Database created successfully.\n";
    } else {
        echo "Database '$database' exists.\n";
    }
    
    // Connect to the specific database
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Check if mata pelajaran table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'tb_mata_pelajaran'");
    if ($stmt->rowCount() == 0) {
        echo "Table 'tb_mata_pelajaran' does not exist.\n";
        echo "Please run the database_sisfo.sql file to create tables.\n";
    } else {
        echo "Table 'tb_mata_pelajaran' exists.\n";
        
        // Check data
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM tb_mata_pelajaran");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "Number of mata pelajaran records: " . $result['count'] . "\n";
        
        if ($result['count'] > 0) {
            // Show sample data
            $stmt = $pdo->query("SELECT kode_mapel, nama_mapel, kategori, status FROM tb_mata_pelajaran LIMIT 5");
            echo "\nSample data:\n";
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "- {$row['kode_mapel']}: {$row['nama_mapel']} ({$row['kategori']}) - {$row['status']}\n";
            }
        }
    }
    
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage() . "\n";
}
?>