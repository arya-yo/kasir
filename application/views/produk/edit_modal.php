<form id="editProdukForm" class="space-y-5" data-produk-id="<?php echo $produk->ProdukID; ?>">
    <!-- Nama Produk -->
    <div>
        <label for="nama_produk" class="block text-sm font-semibold text-gray-700 mb-2">
            <i class="fas fa-tag text-blue-600 mr-1"></i> Nama Produk
        </label>
        <input type="text" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300" id="nama_produk" name="nama_produk" value="<?php echo $produk->NamaProduk; ?>" placeholder="Nama produk" required>
    </div>
    
    <!-- Harga -->
    <div>
        <label for="harga" class="block text-sm font-semibold text-gray-700 mb-2">
            <i class="fas fa-money-bill-wave text-green-600 mr-1"></i> Harga (Rp)
        </label>
        <div class="relative">
            <span class="absolute left-4 top-2.5 text-gray-500 font-semibold">Rp</span>
            <input type="number" class="w-full pl-12 pr-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-300" id="harga" name="harga" value="<?php echo $produk->Harga; ?>" placeholder="0" min="1" required>
        </div>
    </div>
    
    <!-- Stok -->
    <div>
        <label for="stok" class="block text-sm font-semibold text-gray-700 mb-2">
            <i class="fas fa-boxes text-orange-600 mr-1"></i> Stok
        </label>
        <input type="number" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-300" id="stok" name="stok" value="<?php echo $produk->Stok; ?>" placeholder="0" min="0" required>
    </div>
    
    <!-- Info Alert -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mt-4">
        <p class="text-xs text-blue-800 flex items-start gap-2">
            <i class="fas fa-info-circle flex-shrink-0 mt-0.5"></i>
            <span><strong>Catatan:</strong> Klik tombol Simpan di bawah untuk menyimpan perubahan produk ini.</span>
        </p>
    </div>
</form>
