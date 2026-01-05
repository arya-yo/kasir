<div class="space-y-6">
    <!-- Username Section -->
    <div class="border-b border-gray-200 pb-4">
        <label class="block text-sm font-semibold text-gray-600 mb-2"><i class="fas fa-user text-purple-600 mr-2"></i>Username</label>
        <p class="text-xl font-bold text-gray-900"><?php echo $user->Username; ?></p>
    </div>

    <!-- Role Section -->
    <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 p-4 rounded-lg border border-indigo-200">
        <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2"><i class="fas fa-shield-alt text-indigo-600 mr-1"></i>Role</label>
        <div class="flex items-center gap-3">
            <span class="text-lg font-bold <?php echo $user->Role == 'admin' ? 'text-red-600' : 'text-green-600'; ?>">
                <?php echo ucfirst($user->Role); ?>
            </span>
            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold <?php echo $user->Role == 'admin' ? 'bg-red-200 text-red-800' : 'bg-green-200 text-green-800'; ?>">
                <?php echo $user->Role == 'admin' ? 'Administrator' : 'Petugas Kasir'; ?>
            </span>
        </div>
    </div>

    <!-- Info Alert -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex items-start gap-3">
            <i class="fas fa-info-circle text-blue-600 mt-1 flex-shrink-0"></i>
            <div class="text-sm text-gray-700">
                <p class="font-semibold text-blue-900 mb-1">Informasi Pengguna</p>
                <p class="text-blue-800">Klik tombol Edit untuk mengubah data pengguna atau Hapus untuk menghapusnya.</p>
            </div>
        </div>
    </div>
</div>
