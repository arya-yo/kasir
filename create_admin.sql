-- SQL untuk membuat user admin
-- Jalankan query ini di Navicat untuk membuat user admin

-- Pastikan tabel users sudah ada dengan struktur:
-- CREATE TABLE users (
--     UserID INT AUTO_INCREMENT PRIMARY KEY,
--     Username VARCHAR(50) NOT NULL UNIQUE,
--     Password VARCHAR(255) NOT NULL,
--     Role ENUM('admin','petugas') NOT NULL
-- );

-- Insert user admin Arya dengan password 12345
-- Password sudah di-hash menggunakan password_hash('12345', PASSWORD_BCRYPT)
INSERT INTO users (Username, Password, Role) 
VALUES ('Arya', '$2y$10$UUgiDJ8Bz/wfUSByV3JA1uikS0O4fcE3VDRwg6tG.JgyAo8XMiTL6', 'admin');

-- Atau jika user sudah ada, gunakan UPDATE:
-- UPDATE users 
-- SET Password = '$2y$10$UUgiDJ8Bz/wfUSByV3JA1uikS0O4fcE3VDRwg6tG.JgyAo8XMiTL6', 
--     Role = 'admin' 
-- WHERE Username = 'Arya';

-- Cek apakah user berhasil dibuat:
-- SELECT * FROM users WHERE Username = 'Arya';

