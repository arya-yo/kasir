<div class="space-y-6">
    <!-- Product Name Section -->
    <div class="border-b border-gray-200 pb-4">
        <label class="block text-sm font-semibold text-gray-600 mb-2">Nama Produk</label>
        <p class="text-xl font-bold text-gray-900"><?php echo $produk->NamaProduk; ?></p>
    </div>

    <!-- Product Details Grid -->
    <div class="grid grid-cols-2 gap-4">
        <!-- Price Section -->
        <div class="bg-gradient-to-br from-green-50 to-green-100 p-4 rounded-lg border border-green-200">
            <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Harga</label>
            <p class="text-2xl font-bold text-green-600">Rp <?php echo number_format($produk->Harga, 0, ',', '.'); ?></p>
        </div>

        <!-- Stock Section -->
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-4 rounded-lg border border-blue-200">
            <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Stok</label>
            <div class="flex items-center gap-2">
                <span class="text-2xl font-bold <?php echo $produk->Stok > 0 ? 'text-blue-600' : 'text-red-600'; ?>">
                    <?php echo $produk->Stok; ?>
                </span>
                <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold whitespace-nowrap <?php echo $produk->Stok > 0 ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800'; ?>">
                    <?php echo $produk->Stok > 0 ? 'Tersedia' : 'Habis'; ?>
                </span>
            </div>
        </div>
    </div>

    <!-- Additional Info -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex items-start gap-3">
            <i class="fas fa-info-circle text-blue-600 mt-1 flex-shrink-0"></i>
            <div class="text-sm text-gray-700">
                <p class="font-semibold text-blue-900 mb-1">Informasi Produk</p>
                <p class="text-blue-800">Klik tombol Edit untuk mengubah data produk atau Hapus untuk menghapusnya.</p>
            </div>
        </div>
    </div>
</div>
