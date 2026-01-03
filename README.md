# 📋 DOCUMENTASI APLIKASI KASIR
## Sistem Manajemen Kasir - Panduan Lengkap untuk Presentasi

---

## 🎯 **GAMBARAN UMUM APLIKASI**

Aplikasi Kasir adalah sistem manajemen kasir berbasis web yang dibangun menggunakan **CodeIgniter 3** dengan **Tailwind CSS** untuk antarmuka yang modern dan responsif. Aplikasi ini dirancang untuk mengelola transaksi penjualan, data produk, pelanggan, dan laporan penjualan dengan sistem role-based access control (Admin dan Petugas).

---

## 🔐 **1. SISTEM AUTENTIKASI**

### **1.1 Halaman Login**
- **URL**: `/auth/login`
- **Fitur**:
  - Form login dengan validasi real-time
  - Field: Username dan Password
  - Checkbox "Ingat Saya" untuk remember me
  - Animasi fade-in dan slide-up yang smooth
  - Validasi client-side dan server-side
  - Logging aktivitas login (berhasil/gagal)

**Alur Login**:
1. User memasukkan username dan password
2. Sistem memverifikasi kredensial di database
3. Jika valid, session dibuat dengan data:
   - `user_id`: ID user
   - `username`: Username user
   - `role`: Role user (admin/petugas)
   - `logged_in`: Status login (TRUE)
4. Redirect ke Dashboard sesuai role
5. Aktivitas login dicatat di log system

### **1.2 Halaman Register**
- **URL**: `/auth/register`
- **Fitur**:
  - Form registrasi lengkap dengan validasi
  - Field: Nama Depan, Nama Belakang, Email, Username, Password, Konfirmasi Password, Nomor Telepon, Alamat
  - Password strength indicator (real-time)
  - Validasi email format
  - Validasi nomor telepon Indonesia
  - Checkbox persetujuan syarat dan ketentuan
  - Animasi smooth pada semua elemen

### **1.3 Logout**
- **URL**: `/auth/logout`
- **Fitur**:
  - Menghapus semua session data
  - Logging aktivitas logout
  - Redirect ke halaman login

---

## 👤 **2. SISTEM ROLE & AKSES**

Aplikasi memiliki **2 level akses**:

### **2.1 ADMIN**
**Akses Penuh**:
- ✅ Dashboard dengan statistik
- ✅ Master Data (Data User, Data Produk)
- ✅ Data Pelanggan
- ✅ Laporan Penjualan
- ✅ CRUD lengkap untuk semua data

### **2.2 PETUGAS**
**Akses Terbatas**:
- ✅ Dashboard (tanpa statistik)
- ✅ Transaksi Penjualan
- ✅ Data Pelanggan (view only)
- ❌ Tidak bisa akses Master Data
- ❌ Tidak bisa akses Laporan

---

## 📊 **3. DASHBOARD**

### **3.1 Dashboard Admin**
- **URL**: `/dashboard`
- **Fitur**:
  - **Statistik Card** (3 kartu dengan animasi):
    1. **Total User** - Menampilkan jumlah user terdaftar
    2. **Total Produk** - Menampilkan jumlah produk tersedia
    3. **Total Penjualan** - Menampilkan jumlah transaksi penjualan
  - Card dengan gradient background (blue, green, cyan)
  - Hover effect dengan animasi scale dan translate
  - Animasi fade-in dan scale-in yang smooth

### **3.2 Dashboard Petugas**
- **URL**: `/dashboard`
- **Fitur**:
  - Pesan selamat datang
  - Informasi untuk menggunakan menu transaksi penjualan
  - Tidak menampilkan statistik

---

## 👥 **4. MASTER DATA - DATA USER** (Admin Only)

### **4.1 Daftar User**
- **URL**: `/user`
- **Fitur**:
  - Tabel data user dengan kolom:
    - **No**: Nomor urut
    - **Username**: Nama pengguna
    - **Role**: Badge role (Admin = merah, Petugas = hijau)
    - **Aksi**: 3 tombol (Lihat Detail, Edit, Hapus)
  - Pagination (10 data per halaman)
  - Tombol "Tambah User" di kanan atas
  - Animasi hover pada setiap row
  - Responsive design

### **4.2 Tambah User**
- **URL**: `/user/create`
- **Fitur**:
  - Form dengan field:
    - Username (required, min 3 karakter, unique)
    - Password (required, min 5 karakter)
    - Role (dropdown: Admin/Petugas)
  - Validasi real-time
  - Password di-hash menggunakan bcrypt

### **4.3 Edit User**
- **URL**: `/user/edit/{id}`
- **Fitur**:
  - Modal popup dengan form edit
  - Field: Username, Password (optional), Role
  - Jika password kosong, password tidak diubah
  - Validasi dan update via AJAX

### **4.4 Detail User**
- **Fitur**:
  - Modal popup menampilkan detail lengkap user
  - Data di-load via AJAX
  - Animasi loading spinner

### **4.5 Hapus User**
- **Fitur**:
  - Modal konfirmasi sebelum hapus
  - Validasi untuk mencegah hapus user sendiri
  - Soft delete atau hard delete (tergantung implementasi)

---

## 📦 **5. MASTER DATA - DATA PRODUK** (Admin Only)

### **5.1 Daftar Produk**
- **URL**: `/produk`
- **Fitur**:
  - Tabel data produk dengan kolom:
    - **No**: Nomor urut
    - **Nama Produk**: Nama produk
    - **Harga**: Format Rupiah (Rp)
    - **Stok**: Badge warna (Hijau jika ada stok, Merah jika habis)
    - **Aksi**: 3 tombol (Lihat Detail, Edit, Hapus)
  - Pagination (10 data per halaman)
  - Tombol "Tambah Produk" di kanan atas
  - Filter stok (hanya tampil produk dengan stok > 0 untuk petugas)

### **5.2 Tambah Produk**
- **URL**: `/produk/create`
- **Fitur**:
  - Form dengan field:
    - Nama Produk (required)
    - Harga (required, numeric, > 0)
    - Stok (required, integer, >= 0)
  - Validasi real-time
  - Format harga otomatis

### **5.3 Edit Produk**
- **URL**: `/produk/edit/{id}`
- **Fitur**:
  - Modal popup dengan form edit
  - Field: Nama Produk, Harga, Stok
  - Update via AJAX
  - Auto-reload setelah update

### **5.4 Detail Produk**
- **Fitur**:
  - Modal popup menampilkan detail lengkap produk
  - Data di-load via AJAX

### **5.5 Hapus Produk**
- **Fitur**:
  - Modal konfirmasi sebelum hapus
  - Validasi relasi dengan penjualan (jika ada transaksi, tidak bisa dihapus)

---

## 🛒 **6. TRANSAKSI PENJUALAN** (Petugas & Admin)

### **6.1 Halaman Transaksi**
- **URL**: `/penjualan`
- **Fitur Utama**:
  - **Search Produk**: Pencarian produk berdasarkan nama
  - **Tabel Produk**: Menampilkan produk yang tersedia (stok > 0)
  - **Checkbox Pilih**: Untuk memilih produk yang akan dibeli
  - **Input Jumlah**: Tombol +/- dan input manual untuk jumlah
  - **Validasi Stok**: Tidak bisa input melebihi stok tersedia
  - **Total Harga**: Kalkulasi otomatis total harga
  - **Tombol Proses Transaksi**: Aktif jika ada produk dipilih

### **6.2 Alur Transaksi Penjualan**:

**Langkah 1: Pilih Produk**
- User mencari produk (optional)
- Centang checkbox produk yang ingin dibeli
- Set jumlah produk (min 1, max sesuai stok)

**Langkah 2: Input Data Pelanggan**
- Klik "Proses Transaksi"
- Modal muncul untuk input data pelanggan:
  - Nama Pelanggan (required)
  - Alamat (optional)
  - Nomor Telepon (optional)

**Langkah 3: Simpan Transaksi**
- Klik "Simpan Transaksi"
- Sistem melakukan:
  1. Insert data pelanggan (jika belum ada)
  2. Insert data penjualan
  3. Insert detail penjualan (setiap produk)
  4. Update stok produk (stok dikurangi)
  5. Redirect ke halaman sukses

### **6.3 Fitur Khusus**:
- **Pagination**: 10 produk per halaman
- **Real-time Calculation**: Total harga update otomatis
- **Stok Validation**: Validasi stok real-time
- **Responsive Design**: Bisa digunakan di mobile

---

## 👥 **7. DATA PELANGGAN**

### **7.1 Riwayat Pembelian Pelanggan**
- **URL**: `/pelanggan`
- **Fitur**:
  - Tabel riwayat pembelian dengan kolom:
    - **No**: Nomor urut
    - **Tanggal**: Tanggal transaksi (format dd/mm/yyyy)
    - **Nama Pelanggan**: Nama pelanggan
    - **Alamat**: Alamat pelanggan
    - **Telepon**: Nomor telepon
    - **Total Harga**: Total pembelian (format Rupiah)
    - **Aksi**: Tombol "Lihat Detail"
  - Pagination (10 data per halaman)
  - Urutan FIFO (First In First Out) - transaksi lama di atas

### **7.2 Detail Penjualan**
- **Fitur**:
  - Modal popup menampilkan:
    - Informasi pelanggan lengkap
    - Daftar produk yang dibeli
    - Jumlah dan harga per item
    - Total harga keseluruhan
  - Data di-load via AJAX

---

## 📈 **8. LAPORAN PENJUALAN** (Admin Only)

### **8.1 Daftar Laporan**
- **URL**: `/laporan`
- **Fitur**:
  - **Badge Total Penjualan**: Menampilkan total penjualan keseluruhan (format Rupiah)
  - Tabel laporan dengan kolom:
    - **No**: Nomor urut
    - **Tanggal**: Tanggal transaksi
    - **Pelanggan**: Nama pelanggan (atau "Umum" jika tidak ada)
    - **Total Harga**: Total transaksi (format Rupiah, warna primary)
    - **Aksi**: Tombol "Lihat Detail" dan "Hapus"
  - Pagination (10 data per halaman)

### **8.2 Detail Laporan**
- **Fitur**:
  - Modal popup menampilkan detail lengkap transaksi
  - Informasi pelanggan
  - Daftar produk yang dibeli
  - Perhitungan total

### **8.3 Hapus Laporan**
- **Fitur**:
  - Modal konfirmasi sebelum hapus
  - Menghapus data penjualan dan detail penjualan
  - Restore stok produk (stok dikembalikan)
  - Tindakan tidak dapat dibatalkan

---

## 🎨 **9. FITUR UI/UX**

### **9.1 Design System**
- **Framework CSS**: Tailwind CSS
- **Color Scheme**:
  - Primary: `#667eea` (Ungu)
  - Secondary: `#764ba2` (Ungu Tua)
  - Success: Green shades
  - Danger: Red shades
  - Info: Blue shades

### **9.2 Animasi & Transisi**
- **Fade-in**: Elemen muncul dengan fade effect
- **Slide-up**: Konten naik dari bawah
- **Scale-in**: Modal muncul dengan scale effect
- **Hover Effects**: Transisi halus pada semua elemen interaktif
- **Loading Spinner**: Animasi loading saat proses data

### **9.3 Responsive Design**
- **Desktop**: Sidebar fixed, content area dengan margin
- **Tablet**: Sidebar bisa di-collapse
- **Mobile**: Sidebar overlay dengan hamburger menu
- **Breakpoints**: 
  - Mobile: < 768px
  - Tablet: 768px - 1024px
  - Desktop: > 1024px

### **9.4 Sidebar Navigation**
- **Fixed Position**: Sidebar selalu terlihat
- **Collapsible**: Bisa di-collapse untuk lebih banyak ruang
- **Active State**: Menu aktif ditandai dengan background highlight
- **Submenu**: Master Data bisa di-expand/collapse
- **Smooth Transition**: Animasi smooth saat collapse/expand

---

## 🔄 **10. ALUR KERJA APLIKASI**

### **10.1 Alur untuk Admin**

```
1. Login → Dashboard
   ↓
2. Setup Master Data:
   - Tambah User (Admin/Petugas)
   - Tambah Produk (Nama, Harga, Stok)
   ↓
3. Monitoring:
   - Lihat Statistik di Dashboard
   - Lihat Laporan Penjualan
   - Lihat Data Pelanggan
   ↓
4. Maintenance:
   - Edit/Hapus User
   - Edit/Hapus Produk
   - Hapus Laporan (jika perlu)
```

### **10.2 Alur untuk Petugas**

```
1. Login → Dashboard
   ↓
2. Transaksi Penjualan:
   - Cari Produk (optional)
   - Pilih Produk yang akan dibeli
   - Set Jumlah
   - Input Data Pelanggan
   - Simpan Transaksi
   ↓
3. Lihat Riwayat:
   - Lihat Data Pelanggan
   - Lihat Detail Transaksi
```

---

## 📱 **11. FITUR TEKNIS**

### **11.1 Keamanan**
- **Password Hashing**: Menggunakan bcrypt
- **Session Management**: Session-based authentication
- **Role-Based Access Control**: Pembatasan akses berdasarkan role
- **Input Validation**: Validasi di client dan server side
- **SQL Injection Protection**: Menggunakan Query Builder CodeIgniter
- **XSS Protection**: Auto-escaping di CodeIgniter

### **11.2 Database Structure**
- **Tabel Users**: UserID, Username, Password, Role
- **Tabel Produk**: ProdukID, NamaProduk, Harga, Stok
- **Tabel Pelanggan**: PelangganID, NamaPelanggan, Alamat, NomorTelepon
- **Tabel Penjualan**: PenjualanID, PelangganID, TanggalPenjualan, TotalHarga
- **Tabel DetailPenjualan**: DetailID, PenjualanID, ProdukID, Jumlah, SubTotal

### **11.3 Logging System**
- **Auth Logging**: Mencatat aktivitas login/logout
- **Activity Logging**: Mencatat aktivitas penting (opsional)
- **Error Logging**: Mencatat error untuk debugging

---

## 🎯 **12. POIN PENTING UNTUK PRESENTASI**

### **12.1 Keunggulan Aplikasi**
1. ✅ **Modern UI/UX**: Menggunakan Tailwind CSS dengan animasi smooth
2. ✅ **Responsive Design**: Bisa digunakan di desktop, tablet, dan mobile
3. ✅ **Role-Based Access**: Sistem akses yang aman berdasarkan role
4. ✅ **Real-time Validation**: Validasi real-time untuk user experience yang baik
5. ✅ **User-Friendly**: Interface yang intuitif dan mudah digunakan
6. ✅ **Secure**: Password hashing, session management, input validation
7. ✅ **Efficient**: Pagination untuk performa yang baik
8. ✅ **Complete CRUD**: Create, Read, Update, Delete untuk semua data

### **12.2 Fitur Unik**
- **Auto Calculation**: Total harga dihitung otomatis
- **Stok Management**: Stok otomatis berkurang saat transaksi
- **Search Function**: Pencarian produk untuk transaksi cepat
- **Modal System**: Semua detail ditampilkan dalam modal yang smooth
- **Badge System**: Visual indicator untuk role dan stok
- **Gradient Design**: Desain modern dengan gradient background

### **12.3 Teknologi yang Digunakan**
- **Backend**: PHP (CodeIgniter 3)
- **Frontend**: HTML, Tailwind CSS, JavaScript (Vanilla)
- **Database**: MySQL
- **Icons**: Font Awesome 6
- **Animations**: Custom CSS animations dengan Tailwind

---

## 📝 **13. DEMO FLOW**

### **Demo 1: Login sebagai Admin**
1. Buka halaman login
2. Masukkan username dan password admin
3. Lihat dashboard dengan 3 statistik card
4. Jelaskan menu yang tersedia untuk admin

### **Demo 2: Setup Master Data**
1. Buka menu "Data User" → Tambah User baru (role: Petugas)
2. Buka menu "Data Produk" → Tambah beberapa produk
3. Jelaskan fitur CRUD (Create, Read, Update, Delete)

### **Demo 3: Transaksi Penjualan**
1. Logout, login sebagai Petugas
2. Buka menu "Transaksi Penjualan"
3. Cari produk, pilih produk, set jumlah
4. Klik "Proses Transaksi"
5. Input data pelanggan
6. Simpan transaksi
7. Lihat total harga yang terhitung otomatis

### **Demo 4: Laporan & Monitoring**
1. Login kembali sebagai Admin
2. Buka menu "Laporan Penjualan"
3. Lihat badge total penjualan
4. Klik "Lihat Detail" pada salah satu transaksi
5. Jelaskan informasi yang ditampilkan
6. Buka menu "Data Pelanggan" → Lihat riwayat pembelian

### **Demo 5: Fitur UI/UX**
1. Tunjukkan animasi fade-in, slide-up, scale-in
2. Tunjukkan hover effects pada semua elemen
3. Tunjukkan responsive design (resize browser)
4. Tunjukkan sidebar collapse/expand
5. Tunjukkan modal dengan animasi smooth

---

## 🎓 **14. KESIMPULAN**

Aplikasi Kasir ini adalah sistem manajemen kasir yang lengkap dengan:
- ✅ **Fungsionalitas Lengkap**: CRUD untuk semua data
- ✅ **Keamanan**: Role-based access, password hashing, session management
- ✅ **User Experience**: UI modern, animasi smooth, responsive design
- ✅ **Performance**: Pagination, efficient queries
- ✅ **Maintainability**: Code yang rapi dan terstruktur

Aplikasi siap digunakan untuk mengelola transaksi penjualan di toko/retail dengan sistem yang aman, mudah digunakan, dan memiliki tampilan yang modern.

---

**Dokumentasi ini dibuat untuk penjelasan aplikasi kasir berbasis web ini.**

