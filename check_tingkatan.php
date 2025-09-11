<?php
// Check tingkatan data in database
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'sisfo_smk_bina_mandiri';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Checking tingkatan data in database...\n\n";
    
    // Check if tingkatan table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'tb_tingkatan'");
    if ($stmt->rowCount() == 0) {
        echo "Table 'tb_tingkatan' does not exist.\n";
        return;
    }
    
    echo "✅ Table 'tb_tingkatan' exists.\n";
    
    // Check data
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM tb_tingkatan");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "Number of tingkatan records: " . $result['count'] . "\n";
    
    if ($result['count'] > 0) {
        // Show sample data
        $stmt = $pdo->query("SELECT id_tingkatan, nama_tingkatan, keterangan FROM tb_tingkatan ORDER BY id_tingkatan");
        echo "\nTingkatan data:\n";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "- ID: {$row['id_tingkatan']}, Name: {$row['nama_tingkatan']}, Desc: " . ($row['keterangan'] ?: 'No description') . "\n";
        }
    } else {
        echo "\n❌ No tingkatan data found!\n";
        echo "Let's check if there are sample data inserts in the SQL file...\n";
        
        // Insert sample tingkatan data if none exists
        echo "Inserting sample tingkatan data...\n";
        $sample_data = [
            ['X', 'Kelas 10'],
            ['XI', 'Kelas 11'],
            ['XII', 'Kelas 12']
        ];
        
        foreach ($sample_data as $data) {
            $stmt = $pdo->prepare("INSERT INTO tb_tingkatan (nama_tingkatan, keterangan) VALUES (?, ?)");
            $stmt->execute($data);
        }
        
        echo "✅ Sample tingkatan data inserted successfully!\n";
        
        // Show inserted data
        $stmt = $pdo->query("SELECT id_tingkatan, nama_tingkatan, keterangan FROM tb_tingkatan ORDER BY id_tingkatan");
        echo "\nInserted tingkatan data:\n";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "- ID: {$row['id_tingkatan']}, Name: {$row['nama_tingkatan']}, Desc: {$row['keterangan']}\n";
        }
    }
    
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage() . "\n";
}
?>