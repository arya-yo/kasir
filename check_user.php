<?php
/**
 * Script untuk cek user di database
 * Akses: http://localhost/KASIR/check_user.php
 * Setelah selesai, hapus file ini
 */

// Koneksi database langsung
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'KASIR';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<h2>Daftar User di Database</h2>";

// Cek apakah tabel users ada
$table_check = $conn->query("SHOW TABLES LIKE 'users'");
if ($table_check->num_rows == 0) {
    echo "<p style='color: red;'>ERROR: Tabel 'users' tidak ditemukan di database!</p>";
    echo "<p>Pastikan tabel sudah di-import ke database.</p>";
    $conn->close();
    exit;
}

// Ambil semua user
$result = $conn->query("SELECT UserID, Username, Role, Password FROM users");

if ($result->num_rows > 0) {
    echo "<table border='1' cellpadding='10' style='border-collapse: collapse;'>";
    echo "<tr><th>ID</th><th>Username</th><th>Role</th><th>Password Hash</th></tr>";
    
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['UserID'] . "</td>";
        echo "<td>" . $row['Username'] . "</td>";
        echo "<td>" . $row['Role'] . "</td>";
        echo "<td>" . substr($row['Password'], 0, 20) . "...</td>";
        echo "</tr>";
    }
    
    echo "</table>";
    
    // Cek user Arya khusus
    $arya_check = $conn->query("SELECT * FROM users WHERE Username = 'Arya'");
    if ($arya_check->num_rows > 0) {
        $arya = $arya_check->fetch_assoc();
        echo "<h3>User 'Arya' ditemukan!</h3>";
        echo "<p>Username: " . $arya['Username'] . "</p>";
        echo "<p>Role: " . $arya['Role'] . "</p>";
        
        // Test password
        $test_password = '12345';
        if (password_verify($test_password, $arya['Password'])) {
            echo "<p style='color: green;'>✓ Password '12345' COCOK!</p>";
        } else {
            echo "<p style='color: red;'>✗ Password '12345' TIDAK COCOK!</p>";
            echo "<p>Password hash di database: " . $arya['Password'] . "</p>";
        }
    } else {
        echo "<h3 style='color: red;'>User 'Arya' TIDAK ditemukan!</h3>";
        echo "<p>Silakan jalankan insert_admin.php untuk membuat user admin.</p>";
    }
    
} else {
    echo "<p>Tidak ada user di database.</p>";
    echo "<p>Silakan jalankan insert_admin.php untuk membuat user admin.</p>";
}

$conn->close();

echo "<hr>";
echo "<p><a href='insert_admin.php'>Klik di sini untuk membuat user admin</a></p>";
echo "<p style='color: red;'><strong>PENTING: Hapus file check_user.php setelah selesai!</strong></p>";

