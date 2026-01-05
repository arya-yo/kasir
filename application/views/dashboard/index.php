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
    <?php endif; ?>
</div>