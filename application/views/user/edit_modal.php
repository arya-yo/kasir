<form id="editUserForm" class="space-y-5" data-user-id="<?php echo $user->UserID; ?>">
    <!-- Username -->
    <div>
        <label for="username" class="block text-sm font-semibold text-gray-700 mb-2">
            <i class="fas fa-user text-purple-600 mr-1"></i> Username
        </label>
        <input type="text" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-300" id="username" name="username" value="<?php echo $user->Username; ?>" placeholder="Username" required>
    </div>
    
    <!-- Password -->
    <div>
        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
            <i class="fas fa-lock text-red-600 mr-1"></i> Password
        </label>
        <p class="text-xs text-gray-500 mb-2">Kosongkan jika tidak ingin mengubah password</p>
        <input type="password" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-300" id="password" name="password" placeholder="Masukkan password baru (opsional)">
    </div>
    
    <!-- Role -->
    <div>
        <label for="role" class="block text-sm font-semibold text-gray-700 mb-2">
            <i class="fas fa-shield-alt text-indigo-600 mr-1"></i> Role / Jabatan
        </label>
        <select class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-300 bg-white" id="role" name="role" required>
            <option value="admin" <?php echo $user->Role == 'admin' ? 'selected' : ''; ?>>Admin</option>
            <option value="petugas" <?php echo $user->Role == 'petugas' ? 'selected' : ''; ?>>Petugas</option>
        </select>
    </div>
    
    <!-- Info Alert -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mt-4">
        <p class="text-xs text-blue-800 flex items-start gap-2">
            <i class="fas fa-info-circle flex-shrink-0 mt-0.5"></i>
            <span><strong>Catatan:</strong> Klik tombol Simpan di bawah untuk menyimpan perubahan pengguna ini.</span>
        </p>
    </div>
</form>
