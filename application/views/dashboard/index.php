<div class="animate-fade-in">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Selamat Datang, <?php echo $user['username']; ?>!</h2>
    
    <?php if ($user['role'] == 'admin'): ?>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-lg p-6 shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1 hover:scale-105 animate-scale-in">
                <h5 class="text-lg font-semibold mb-3"><i class="fas fa-users mr-2"></i> Total User</h5>
                <h2 class="text-4xl font-bold"><?php echo isset($total_user) ? $total_user : '0'; ?></h2>
            </div>
            <div class="bg-gradient-to-br from-green-500 to-green-600 text-white rounded-lg p-6 shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1 hover:scale-105 animate-scale-in" style="animation-delay: 0.1s">
                <h5 class="text-lg font-semibold mb-3"><i class="fas fa-box mr-2"></i> Total Produk</h5>
                <h2 class="text-4xl font-bold"><?php echo isset($total_produk) ? $total_produk : '0'; ?></h2>
            </div>
            <div class="bg-gradient-to-br from-cyan-500 to-cyan-600 text-white rounded-lg p-6 shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1 hover:scale-105 animate-scale-in" style="animation-delay: 0.2s">
                <h5 class="text-lg font-semibold mb-3"><i class="fas fa-shopping-cart mr-2"></i> Total Penjualan</h5>
                <h2 class="text-4xl font-bold"><?php echo isset($total_penjualan) ? $total_penjualan : '0'; ?></h2>
            </div>
        </div>

        <!-- Kalender Real-Time Admin -->
        <div class="bg-white rounded-lg shadow-lg p-6 border border-gray-200 animate-scale-in mb-8">
            <!-- Info Waktu -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Tanggal Besar -->
                <div class="text-center">
                    <div class="text-5xl font-bold text-blue-600 mb-2" id="dateValueAdmin">14</div>
                    <div class="text-sm text-gray-600">Tanggal Hari Ini</div>
                </div>
                <!-- Bulan dan Tahun -->
                <div class="text-center">
                    <div class="text-3xl font-semibold text-gray-800 mb-2" id="monthYearAdmin">Januari 2026</div>
                    <div id="dayNameAdmin" class="text-sm text-gray-600 font-medium">Rabu</div>
                </div>
                <!-- Jam Digital -->
                <div class="text-center">
                    <div class="text-4xl font-mono font-bold text-blue-600 mb-2" id="currentTimeAdmin">00:00:00</div>
                    <div class="text-sm text-gray-600">Waktu Saat Ini</div>
                </div>
            </div>

            <!-- Mini Calendar -->
            <div class="bg-gray-50 rounded-lg p-6">
                <h6 class="font-semibold text-gray-800 text-center mb-4 text-lg" id="calendarMonthAdmin">Januari 2026</h6>
                <div id="calendarGridAdmin" class="grid gap-2"></div>
            </div>
        </div>
    <?php elseif ($user['role'] == 'petugas'): ?>
        <!-- Dashboard Petugas -->
        <div class="grid grid-cols-1 gap-6 mb-8">
            <!-- Card Statistik dan Shortcut -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Card Total Penjualan -->
                <div class="bg-gradient-to-br from-cyan-500 to-cyan-600 text-white rounded-lg p-6 shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1 hover:scale-105 animate-scale-in">
                    <h5 class="text-lg font-semibold mb-3"><i class="fas fa-shopping-cart mr-2"></i> Total Penjualan</h5>
                    <h2 class="text-4xl font-bold"><?php echo isset($total_penjualan) ? $total_penjualan : '0'; ?></h2>
                </div>

                <!-- Card Total Pelanggan -->
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 text-white rounded-lg p-6 shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1 hover:scale-105 animate-scale-in" style="animation-delay: 0.1s">
                    <h5 class="text-lg font-semibold mb-3"><i class="fas fa-users mr-2"></i> Pelanggan Tercatat</h5>
                    <h2 class="text-4xl font-bold"><?php echo isset($total_pelanggan) ? $total_pelanggan : '0'; ?></h2>
                </div>

                <!-- Shortcut Transaksi Penjualan -->
                <a href="<?php echo site_url('penjualan'); ?>" class="bg-gradient-to-br from-orange-500 to-orange-600 text-white rounded-lg p-6 shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1 hover:scale-105 animate-scale-in cursor-pointer" style="animation-delay: 0.2s">
                    <h5 class="text-lg font-semibold mb-3"><i class="fas fa-receipt mr-2"></i> Transaksi Penjualan</h5>
                    <p class="text-sm opacity-90">Buat transaksi baru</p>
                </a>

                <!-- Shortcut Riwayat Pelanggan -->
                <a href="<?php echo site_url('pelanggan'); ?>" class="bg-gradient-to-br from-pink-500 to-pink-600 text-white rounded-lg p-6 shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1 hover:scale-105 animate-scale-in cursor-pointer" style="animation-delay: 0.3s">
                    <h5 class="text-lg font-semibold mb-3"><i class="fas fa-history mr-2"></i> Riwayat Pelanggan</h5>
                    <p class="text-sm opacity-90">Lihat riwayat pelanggan</p>
                </a>
            </div>

            <!-- Kalender Real-Time -->
            <div class="bg-white rounded-lg shadow-lg p-6 border border-gray-200 animate-scale-in">
                <!-- Info Waktu -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <!-- Tanggal Besar -->
                    <div class="text-center">
                        <div class="text-5xl font-bold text-blue-600 mb-2" id="dateValue">14</div>
                        <div class="text-sm text-gray-600">Tanggal Hari Ini</div>
                    </div>
                    <!-- Bulan dan Tahun -->
                    <div class="text-center">
                        <div class="text-3xl font-semibold text-gray-800 mb-2" id="monthYear">Januari 2026</div>
                        <div id="dayName" class="text-sm text-gray-600 font-medium">Rabu</div>
                    </div>
                    <!-- Jam Digital -->
                    <div class="text-center">
                        <div class="text-4xl font-mono font-bold text-blue-600 mb-2" id="currentTime">00:00:00</div>
                        <div class="text-sm text-gray-600">Waktu Saat Ini</div>
                    </div>
                </div>

                <!-- Mini Calendar -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <h6 class="font-semibold text-gray-800 text-center mb-4 text-lg" id="calendarMonth">Januari 2026</h6>
                    <div id="calendarGrid" class="grid gap-2"></div>
                </div>
            </div>
        </div>
    <?php endif; ?>

</div>

<script>
    // Kalender dan waktu real-time
    function updateCalendarAdmin() {
        const now = new Date();
        const year = now.getFullYear();
        const month = now.getMonth();
        const date = now.getDate();
        
        // Update tanggal besar
        document.getElementById('dateValueAdmin').textContent = date;
        
        // Update bulan dan tahun
        const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                       'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        
        document.getElementById('monthYearAdmin').textContent = months[month] + ' ' + year;
        document.getElementById('dayNameAdmin').textContent = days[now.getDay()];
        document.getElementById('calendarMonthAdmin').textContent = months[month] + ' ' + year;
        
        // Generate mini calendar
        const firstDay = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        
        let html = '';
        
        // Header hari
        const dayHeaders = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
        dayHeaders.forEach(day => {
            html += `<div class="font-semibold text-gray-700 py-2 text-center text-sm">${day}</div>`;
        });
        
        // Empty cells sebelum tanggal pertama
        for (let i = 0; i < firstDay; i++) {
            html += '<div class="py-2"></div>';
        }
        
        // Tanggal-tanggal
        for (let i = 1; i <= daysInMonth; i++) {
            const isToday = i === date;
            if (isToday) {
                html += `<div class="py-2 text-center bg-blue-500 text-white rounded-md font-bold text-sm">${i}</div>`;
            } else {
                html += `<div class="py-2 text-center text-gray-700 hover:bg-gray-200 rounded-md text-sm font-medium cursor-pointer">${i}</div>`;
            }
        }
        
        // Buat grid 7 kolom
        const calendarGrid = document.getElementById('calendarGridAdmin');
        calendarGrid.className = 'grid grid-cols-7 gap-2 text-center';
        calendarGrid.innerHTML = html;
    }

    function updateCalendarPetugas() {
        const now = new Date();
        const year = now.getFullYear();
        const month = now.getMonth();
        const date = now.getDate();
        
        // Update tanggal besar
        document.getElementById('dateValue').textContent = date;
        
        // Update bulan dan tahun
        const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                       'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        
        document.getElementById('monthYear').textContent = months[month] + ' ' + year;
        document.getElementById('dayName').textContent = days[now.getDay()];
        document.getElementById('calendarMonth').textContent = months[month] + ' ' + year;
        
        // Generate mini calendar
        const firstDay = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        
        let html = '';
        
        // Header hari
        const dayHeaders = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
        dayHeaders.forEach(day => {
            html += `<div class="font-semibold text-gray-700 py-2 text-center text-sm">${day}</div>`;
        });
        
        // Empty cells sebelum tanggal pertama
        for (let i = 0; i < firstDay; i++) {
            html += '<div class="py-2"></div>';
        }
        
        // Tanggal-tanggal
        for (let i = 1; i <= daysInMonth; i++) {
            const isToday = i === date;
            if (isToday) {
                html += `<div class="py-2 text-center bg-blue-500 text-white rounded-md font-bold text-sm">${i}</div>`;
            } else {
                html += `<div class="py-2 text-center text-gray-700 hover:bg-gray-200 rounded-md text-sm font-medium cursor-pointer">${i}</div>`;
            }
        }
        
        // Buat grid 7 kolom
        const calendarGrid = document.getElementById('calendarGrid');
        if (calendarGrid) {
            calendarGrid.className = 'grid grid-cols-7 gap-2 text-center';
            calendarGrid.innerHTML = html;
        }
    }
    
    // Update waktu real-time untuk admin
    function updateTimeAdmin() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        const timeElement = document.getElementById('currentTimeAdmin');
        if (timeElement) {
            timeElement.textContent = `${hours}:${minutes}:${seconds}`;
        }
    }

    // Update waktu real-time untuk petugas
    function updateTimePetugas() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        const timeElement = document.getElementById('currentTime');
        if (timeElement) {
            timeElement.textContent = `${hours}:${minutes}:${seconds}`;
        }
    }
    
    // Jalankan saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
        // Cek apakah admin atau petugas
        const dateValueAdmin = document.getElementById('dateValueAdmin');
        const dateValuePetugas = document.getElementById('dateValue');
        
        if (dateValueAdmin) {
            updateCalendarAdmin();
            updateTimeAdmin();
            setInterval(updateTimeAdmin, 1000);
            setInterval(updateCalendarAdmin, 60000);
        }
        
        if (dateValuePetugas) {
            updateCalendarPetugas();
            updateTimePetugas();
            setInterval(updateTimePetugas, 1000);
            setInterval(updateCalendarPetugas, 60000);
        }
    });
</script>