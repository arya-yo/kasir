<div class="animate-fade-in">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h3 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                <i class="fas fa-user-plus text-purple-600"></i> Tambah User Baru
            </h3>
            <p class="text-gray-500 mt-2">Lengkapi form di bawah untuk membuat user baru</p>
        </div>
        <a href="<?php echo site_url('user'); ?>" class="bg-white hover:bg-gray-50 text-gray-700 px-6 py-3 rounded-lg border border-gray-300 transition-all duration-300 hover:shadow-md font-medium flex items-center gap-2">
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
        <form method="post" action="<?php echo site_url('user/store'); ?>" class="space-y-6">
            
            <!-- Username -->
            <div>
                <label for="username" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-user text-purple-600 mr-1"></i> Username
                </label>
                <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-300" id="username" name="username" placeholder="Masukkan username" required>
            </div>
            
            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-lock text-red-600 mr-1"></i> Password
                </label>
                <input type="password" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-300" id="password" name="password" placeholder="Masukkan password" required>
            </div>
            
            <!-- Role -->
            <div>
                <label for="role" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-shield-alt text-indigo-600 mr-1"></i> Role / Jabatan
                </label>
                <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-300 bg-white" id="role" name="role" required>
                    <option value="">Pilih Role</option>
                    <option value="admin">Admin</option>
                    <option value="petugas">Petugas</option>
                </select>
            </div>

            <!-- Divider -->
            <div class="border-t border-gray-200 pt-6"></div>

            <!-- Form Actions -->
            <div class="flex gap-3 justify-end">
                <a href="<?php echo site_url('user'); ?>" class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-all duration-300 hover:shadow-md">
                    <i class="fas fa-times mr-2"></i> Batal
                </a>
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white font-medium rounded-lg transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5">
                    <i class="fas fa-save mr-2"></i> Buat User
                </button>
            </div>
        </form>
    </div>
</div>

