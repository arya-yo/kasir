<div class="space-y-6">
    <!-- Header Card -->
    <div class="bg-gradient-to-r from-indigo-50 to-indigo-100 border border-indigo-200 rounded-lg p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Date -->
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2"><i class="fas fa-calendar text-indigo-600 mr-1"></i>Tanggal Penjualan</label>
                <p class="text-lg font-bold text-gray-900"><?php echo date('d/m/Y', strtotime($penjualan->TanggalPenjualan)); ?></p>
            </div>
            <!-- Total Price -->
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2"><i class="fas fa-money-bill-wave text-green-600 mr-1"></i>Total Harga</label>
                <p class="text-lg font-bold text-green-600">Rp <?php echo number_format($penjualan->TotalHarga, 0, ',', '.'); ?></p>
            </div>
            <!-- Customer Name -->
            <div>
                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2"><i class="fas fa-user-circle text-purple-600 mr-1\"></i>Pelanggan</label>
                <p class="text-lg font-bold text-gray-900"><?php echo $penjualan->NamaPelanggan ? $penjualan->NamaPelanggan : 'Umum'; ?></p>
            </div>
        </div>
    </div>

    <!-- Contact Information -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <label class="block text-sm font-semibold text-gray-700 mb-2"><i class="fas fa-phone text-blue-600 mr-1"></i>Nomor Telepon</label>
            <p class="text-lg font-bold text-gray-900"><?php echo $penjualan->NomorTelepon ? $penjualan->NomorTelepon : '-'; ?></p>
        </div>
        <?php if ($penjualan->Alamat): ?>
        <div class="bg-orange-50 border border-orange-200 rounded-lg p-4">
            <label class="block text-sm font-semibold text-gray-700 mb-2"><i class="fas fa-map-marker-alt text-orange-600 mr-1"></i>Alamat</label>
            <p class="text-gray-900"><?php echo $penjualan->Alamat; ?></p>
        </div>
        <?php endif; ?>
    </div>

    <!-- Divider -->
    <div class="border-t-2 border-gray-200"></div>

    <!-- Items Table -->
    <div>
        <h6 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2"><i class="fas fa-box text-yellow-600"></i>Detail Barang</h6>
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-800 text-white">
                        <th class="px-4 py-3 text-left">Produk</th>
                        <th class="px-4 py-3 text-center">Harga</th>
                        <th class="px-4 py-3 text-center">Jumlah</th>
                        <th class="px-4 py-3 text-right pr-4">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php if (empty($details)): ?>
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-gray-500">Tidak ada detail barang</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($details as $detail): ?>
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-4 py-3 font-medium text-gray-900"><?php echo $detail->NamaProduk; ?></td>
                            <td class="px-4 py-3 text-center">Rp <?php echo number_format($detail->Harga, 0, ',', '.'); ?></td>
                            <td class="px-4 py-3 text-center font-semibold"><?php echo $detail->JumlahProduk; ?></td>
                            <td class="px-4 py-3 text-right font-bold text-green-600">Rp <?php echo number_format($detail->Subtotal, 0, ',', '.'); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

