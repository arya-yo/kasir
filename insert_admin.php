<?php
/**
 * Script untuk insert user admin
 * Jalankan sekali saja melalui browser: http://localhost/KASIR/insert_admin.php
 * Setelah berhasil, hapus file ini untuk keamanan
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

// Hash password
$password_hash = password_hash('12345', PASSWORD_BCRYPT);

// Cek apakah sudah ada
$check = $conn->query("SELECT * FROM users WHERE Username = 'Arya'");

if ($check->num_rows > 0) {
    echo "<h2>User admin 'Arya' sudah ada di database!</h2>";
    echo "<p>Username: Arya</p>";
    echo "<p>Password: 12345</p>";
    echo "<p>Role: admin</p>";
} else {
    // Insert admin
    $stmt = $conn->prepare("INSERT INTO users (Username, Password, Role) VALUES (?, ?, ?)");
    $role = 'admin';
    $stmt->bind_param("sss", $username_val, $password_hash, $role);
    
    $username_val = 'Arya';
    
    if ($stmt->execute()) {
        echo "<h2>User admin berhasil dibuat!</h2>";
        echo "<p>Username: Arya</p>";
        echo "<p>Password: 12345</p>";
        echo "<p>Role: admin</p>";
        echo "<p style='color: red;'><strong>PENTING: Hapus file insert_admin.php setelah ini untuk keamanan!</strong></p>";
    } else {
        echo "<h2>Error: Gagal membuat user admin</h2>";
        echo "<p>" . $stmt->error . "</p>";
    }
    
    $stmt->close();
}

$conn->close();

