<div class="animate-fade-in">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h3 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                <i class="fas fa-user-check text-cyan-600"></i> Tambah Pelanggan Baru
            </h3>
            <p class="text-gray-500 mt-2">Daftarkan pelanggan baru ke dalam sistem</p>
        </div>
        <a href="<?php echo site_url('pelanggan'); ?>" class="bg-white hover:bg-gray-50 text-gray-700 px-6 py-3 rounded-lg border border-gray-300 transition-all duration-300 hover:shadow-md font-medium flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-lg mb-6 animate-fade-in flex justify-between items-center" role="alert">
            <span class="flex items-center gap-2"><i class="fas fa-exclamation-circle"></i> <?php echo $this->session->flashdata('error'); ?></span>
            <button type="button" onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700">&times;</button>
        </div>
    <?php endif; ?>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-8">
        <form method="post" action="<?php echo site_url('pelanggan/store'); ?>" class="space-y-6">
            
            <!-- Nama Pelanggan -->
            <div>
                <label for="nama_pelanggan" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-user-circle text-cyan-600 mr-1"></i> Nama Pelanggan
                </label>
                <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-300" id="nama_pelanggan" name="nama_pelanggan" placeholder="Masukkan nama pelanggan" required>
            </div>
            
            <!-- Alamat -->
            <div>
                <label for="alamat" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-map-marker-alt text-orange-600 mr-1"></i> Alamat
                </label>
                <textarea class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-300 resize-none" id="alamat" name="alamat" rows="3" placeholder="Masukkan alamat lengkap"></textarea>
            </div>
            
            <!-- Nomor Telepon -->
            <div>
                <label for="nomor_telepon" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-phone text-green-600 mr-1"></i> Nomor Telepon
                </label>
                <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-300" id="nomor_telepon" name="nomor_telepon" placeholder="Contoh: 081234567890">
            </div>

            <!-- Divider -->
            <div class="border-t border-gray-200 pt-6"></div>

            <!-- Form Actions -->
            <div class="flex gap-3 justify-end">
                <a href="<?php echo site_url('pelanggan'); ?>" class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-all duration-300 hover:shadow-md">
                    <i class="fas fa-times mr-2"></i> Batal
                </a>
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-cyan-500 to-cyan-600 hover:from-cyan-600 hover:to-cyan-700 text-white font-medium rounded-lg transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5">
                    <i class="fas fa-save mr-2"></i> Simpan Pelanggan
                </button>
            </div>
        </form>
    </div>
</div>

