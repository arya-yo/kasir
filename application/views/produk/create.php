<div class="animate-fade-in">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h3 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                <i class="fas fa-plus-circle text-blue-600"></i> Tambah Produk Baru
            </h3>
            <p class="text-gray-500 mt-2">Lengkapi form di bawah untuk menambahkan produk baru ke sistem</p>
        </div>
        <a href="<?php echo site_url('produk'); ?>" class="bg-white hover:bg-gray-50 text-gray-700 px-6 py-3 rounded-lg border border-gray-300 transition-all duration-300 hover:shadow-md font-medium flex items-center gap-2">
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
        <form method="post" action="<?php echo site_url('produk/store'); ?>" class="space-y-6">
            
            <!-- Nama Produk -->
            <div>
                <label for="nama_produk" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-tag text-blue-600 mr-1"></i> Nama Produk
                </label>
                <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300" id="nama_produk" name="nama_produk" placeholder="Masukkan nama produk" required>
            </div>
            
            <!-- Harga -->
            <div>
                <label for="harga" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-money-bill-wave text-green-600 mr-1"></i> Harga (Rp)
                </label>
                <div class="relative">
                    <span class="absolute left-4 top-3.5 text-gray-500 font-semibold">Rp</span>
                    <input type="number" class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-300" id="harga" name="harga" placeholder="0" min="0" step="1" required>
                </div>
            </div>
            
            <!-- Stok -->
            <div>
                <label for="stok" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-boxes text-orange-600 mr-1"></i> Stok
                </label>
                <input type="number" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-300" id="stok" name="stok" placeholder="0" min="0" required>
            </div>

            <!-- Divider -->
            <div class="border-t border-gray-200 pt-6"></div>

            <!-- Form Actions -->
            <div class="flex gap-3 justify-end">
                <a href="<?php echo site_url('produk'); ?>" class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-all duration-300 hover:shadow-md">
                    <i class="fas fa-times mr-2"></i> Batal
                </a>
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-medium rounded-lg transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5">
                    <i class="fas fa-save mr-2"></i> Simpan Produk
                </button>
            </div>
        </form>
    </div>
</div>

