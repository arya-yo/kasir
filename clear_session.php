<?php
/**
 * Script untuk clear session
 * Akses: http://localhost/KASIR/clear_session.php
 * Setelah berhasil, hapus file ini
 */

session_start();
session_destroy();

// Clear semua cookies
if (isset($_SERVER['HTTP_COOKIE'])) {
    $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
    foreach($cookies as $cookie) {
        $parts = explode('=', $cookie);
        $name = trim($parts[0]);
        setcookie($name, '', time()-1000);
        setcookie($name, '', time()-1000, '/');
    }
}

echo "<h2>Session berhasil dihapus!</h2>";
echo "<p><a href='http://localhost/KASIR/'>Klik di sini untuk kembali ke halaman login</a></p>";
echo "<p style='color: red;'><strong>PENTING: Hapus file clear_session.php setelah ini!</strong></p>";

