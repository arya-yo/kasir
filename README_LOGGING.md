# Sistem Logging Aplikasi KASIR

## Konfigurasi

Sistem logging sudah diaktifkan dengan konfigurasi berikut:
- **Log Threshold**: 4 (All Messages) - Mencatat semua level log
- **Log Path**: `application/logs/`
- **Log Format**: `log-YYYY-MM-DD.php`
- **Log Date Format**: `Y-m-d H:i:s`

## File Log

Semua log akan tersimpan di folder `application/logs/` dengan format:
- `log-2024-01-15.php` (contoh untuk tanggal 15 Januari 2024)

## Helper Functions

### 1. app_log_error()
Log error dengan detail lengkap
```php
app_log_error('Pesan error', ['key' => 'value'], __FILE__, __LINE__);
```

### 2. app_log_info()
Log informasi umum
```php
app_log_info('Informasi penting', ['data' => 'value']);
```

### 3. app_log_debug()
Log untuk debugging
```php
app_log_debug('Debug message', $variable);
```

### 4. app_log_database()
Log error database
```php
app_log_database($query, $error_message);
```

### 5. app_log_auth()
Log aktivitas authentication
```php
app_log_auth('login', 'username', true);  // Login berhasil
app_log_auth('logout', 'username', true); // Logout
app_log_auth('login', 'username', false); // Login gagal
```

### 6. app_log_transaction()
Log transaksi penting
```php
app_log_transaction('penjualan', 'create', $id, $data);
```

## Contoh Penggunaan

### Di Controller
```php
// Load helper
$this->load->helper('app_log');

// Log error
try {
    // kode yang mungkin error
} catch (Exception $e) {
    app_log_error($e->getMessage(), ['file' => __FILE__, 'line' => __LINE__], __FILE__, __LINE__);
}

// Log database error
if (!$this->db->insert('table', $data)) {
    app_log_database($this->db->last_query(), $this->db->error()['message']);
}

// Log transaksi
app_log_transaction('penjualan', 'create', $penjualan_id, ['total' => $total]);
```

## Informasi yang Dicatat

Setiap log akan mencakup:
- **Timestamp**: Waktu kejadian
- **Level**: ERROR, DEBUG, INFO
- **Message**: Pesan log
- **User**: Username dan role (jika sudah login)
- **IP Address**: Alamat IP pengguna
- **File & Line**: Lokasi error (untuk error)
- **Context**: Data tambahan (jika ada)

## Keamanan

Folder `application/logs/` sudah dilindungi dengan `.htaccess` untuk mencegah akses langsung melalui browser.

## Catatan

- Log file akan dibuat otomatis setiap hari
- Log lama bisa dihapus secara manual jika diperlukan
- Pastikan folder `application/logs/` memiliki permission write (755 atau 777)

