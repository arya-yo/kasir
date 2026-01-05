<div class="animate-fade-in">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-2xl font-bold text-gray-800">Data User</h3>
        <button onclick="showCreateModal()" class="bg-gradient-to-br from-blue-500 to-blue-600 text-white px-4 py-2 rounded-lg hover:shadow-lg transition-all duration-300 hover:-translate-y-0.5 hover:scale-105">
            <i class="fas fa-plus mr-2"></i> Tambah User
        </button>
    </div>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 animate-fade-in flex justify-between items-center">
            <span><i class="fas fa-check-circle mr-2"></i> <?php echo $this->session->flashdata('success'); ?></span>
            <button type="button" onclick="this.parentElement.remove()" class="text-green-700 hover:text-green-900">&times;</button>
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 animate-fade-in flex justify-between items-center">
            <span><i class="fas fa-exclamation-circle mr-2"></i> <?php echo $this->session->flashdata('error'); ?></span>
            <button type="button" onclick="this.parentElement.remove()" class="text-red-700 hover:text-red-900">&times;</button>
        </div>
    <?php endif; ?>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="px-4 py-3 text-left">No</th>
                    <th class="px-4 py-3 text-left">Username</th>
                    <th class="px-4 py-3 text-left">Role</th>
                    <th class="px-4 py-3 text-right pr-4">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php if (empty($users)): ?>
                    <tr>
                        <td colspan="4" class="px-4 py-8 text-center text-gray-500">Tidak ada data user</td>
                    </tr>
                <?php else: ?>
                    <?php 
                        $page = isset($page) ? $page : 1;
                        $per_page = 10;
                        $total = count($users);
                        $start = ($page - 1) * $per_page;
                        $users_page = array_slice($users, $start, $per_page);
                        $total_pages = ceil($total / $per_page);
                        $no = $start + 1;
                    ?>
                    <?php foreach ($users_page as $user): ?>
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-4 py-3"><?php echo $no++; ?></td>
                        <td class="px-4 py-3 font-medium"><?php echo $user->Username; ?></td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 rounded text-xs font-semibold <?php echo $user->Role == 'admin' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800'; ?>">
                                <?php echo ucfirst($user->Role); ?>
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right whitespace-nowrap">
                            <button type="button" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1.5 rounded text-sm mr-1 transition-all duration-300 hover:shadow-md" onclick="showDetailModal(<?php echo $user->UserID; ?>)" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button type="button" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1.5 rounded text-sm mr-1 transition-all duration-300 hover:shadow-md" onclick="showEditModal(<?php echo $user->UserID; ?>)" title="Edit User">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded text-sm transition-all duration-300 hover:shadow-md" onclick="showDeleteConfirm(<?php echo $user->UserID; ?>, '<?php echo addslashes($user->Username); ?>')" title="Hapus User">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if (!empty($users) && $total_pages > 1): ?>
    <nav class="flex justify-center mt-6">
        <ul class="flex gap-2">
            <?php if ($page > 1): ?>
            <li>
                <a class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-300" href="<?php echo site_url('user?page=' . ($page - 1)); ?>">
                    <i class="fas fa-chevron-left mr-1"></i> Sebelumnya
                </a>
            </li>
            <?php else: ?>
            <li>
                <span class="px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg text-gray-400 cursor-not-allowed">
                    <i class="fas fa-chevron-left mr-1"></i> Sebelumnya
                </span>
            </li>
            <?php endif; ?>
            
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <li>
                <a class="px-4 py-2 rounded-lg transition-all duration-300 <?php echo $i == $page ? 'bg-gradient-to-br from-blue-500 to-blue-600 text-white shadow-md' : 'bg-white border border-gray-300 hover:bg-gray-50'; ?>" href="<?php echo site_url('user?page=' . $i); ?>">
                    <?php echo $i; ?>
                </a>
            </li>
            <?php endfor; ?>
            
            <?php if ($page < $total_pages): ?>
            <li>
                <a class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-300" href="<?php echo site_url('user?page=' . ($page + 1)); ?>">
                    Selanjutnya <i class="fas fa-chevron-right ml-1"></i>
                </a>
            </li>
            <?php else: ?>
            <li>
                <span class="px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg text-gray-400 cursor-not-allowed">
                    Selanjutnya <i class="fas fa-chevron-right ml-1"></i>
                </span>
            </li>
            <?php endif; ?>
        </ul>
    </nav>
    <?php endif; ?>

    <!-- Toast Notification Container -->
    <div id="toastContainer" class="fixed top-4 right-4 z-50 space-y-2"></div>

    <!-- Modal Create User -->
    <div class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" id="createModal">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4 animate-scale-in max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center p-5 border-b">
                <h5 class="text-lg font-semibold">Tambah User Baru</h5>
                <button type="button" onclick="closeModal('createModal')" class="text-gray-400 hover:text-gray-600 text-xl">&times;</button>
            </div>
            <div class="p-5">
                <form id="createUserForm" class="space-y-4">
                    <!-- Username -->
                    <div>
                        <label for="create_username" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-user text-purple-600 mr-1"></i> Username
                        </label>
                        <input type="text" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-300" id="create_username" name="username" placeholder="Username" required>
                    </div>
                    
                    <!-- Password -->
                    <div>
                        <label for="create_password" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-lock text-red-600 mr-1"></i> Password
                        </label>
                        <input type="password" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-300" id="create_password" name="password" placeholder="Password" required>
                    </div>
                    
                    <!-- Role -->
                    <div>
                        <label for="create_role" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-shield-alt text-indigo-600 mr-1"></i> Role / Jabatan
                        </label>
                        <select class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-300 bg-white" id="create_role" name="role" required>
                            <option value="">Pilih Role</option>
                            <option value="admin">Admin</option>
                            <option value="petugas">Petugas</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="p-5 border-t flex justify-end gap-2">
                <button type="button" onclick="closeModal('createModal')" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg transition-colors duration-300">Batal</button>
                <button type="button" onclick="submitCreateUser()" class="px-4 py-2 bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-lg hover:shadow-lg transition-all duration-300">
                    <i class="fas fa-save mr-2"></i> Simpan
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Detail User -->
    <div class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" id="detailModal">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4 animate-scale-in">
            <div class="flex justify-between items-center p-5 border-b">
                <h5 class="text-lg font-semibold">Detail User</h5>
                <button type="button" onclick="closeModal('detailModal')" class="text-gray-400 hover:text-gray-600 text-xl">&times;</button>
            </div>
            <div class="p-5" id="modalBody">
                <div class="text-center py-8">
                    <div class="inline-block w-8 h-8 border-4 border-blue-500 border-t-transparent rounded-full animate-spin"></div>
                </div>
            </div>
            <div class="p-5 border-t flex justify-end">
                <button type="button" onclick="closeModal('detailModal')" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg transition-colors duration-300">Tutup</button>
            </div>
        </div>
    </div>

    <!-- Modal Edit User -->
    <div class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" id="editModal">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4 animate-scale-in">
            <div class="flex justify-between items-center p-5 border-b">
                <h5 class="text-lg font-semibold">Edit User</h5>
                <button type="button" onclick="closeModal('editModal')" class="text-gray-400 hover:text-gray-600 text-xl">&times;</button>
            </div>
            <div class="p-5" id="editModalBody">
                <div class="text-center py-8">
                    <div class="inline-block w-8 h-8 border-4 border-blue-500 border-t-transparent rounded-full animate-spin"></div>
                </div>
            </div>
            <div class="p-5 border-t flex justify-end gap-2">
                <button type="button" onclick="closeModal('editModal')" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg transition-colors duration-300">Batal</button>
                <button type="button" onclick="submitEditUser()" class="px-4 py-2 bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-lg hover:shadow-lg transition-all duration-300">
                    <i class="fas fa-save mr-2"></i> Simpan
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Delete -->
    <div class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" id="confirmDeleteModal">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4 border-2 border-red-500 animate-scale-in">
            <div class="bg-red-500 text-white p-5 rounded-t-lg">
                <h5 class="text-lg font-semibold"><i class="fas fa-exclamation-triangle mr-2"></i> Konfirmasi Hapus</h5>
            </div>
            <div class="p-5">
                <p class="mb-2">Apakah Anda yakin ingin menghapus user ini?</p>
                <p id="deleteInfo" class="text-gray-600 text-sm mb-2">Username: <strong id="userName"></strong></p>
                <p class="text-gray-600 text-sm">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="p-5 border-t flex justify-end gap-2">
                <button type="button" onclick="closeModal('confirmDeleteModal')" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg transition-colors duration-300">Batal</button>
                <button type="button" onclick="confirmDelete()" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg transition-all duration-300 hover:shadow-lg">
                    <i class="fas fa-trash mr-2"></i> Ya, Hapus
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let currentUserID = null;
    let editUserID = null;

    function showDetailModal(userID) {
        const modal = document.getElementById('detailModal');
        const modalBody = document.getElementById('modalBody');
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        
        fetch('<?php echo site_url('user/getDetail'); ?>/' + userID)
            .then(response => response.text())
            .then(data => {
                modalBody.innerHTML = data;
            })
            .catch(error => {
                modalBody.innerHTML = '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">Gagal memuat data</div>';
                console.error('Error:', error);
            });
    }

    function showEditModal(userID) {
        editUserID = userID;
        const modal = document.getElementById('editModal');
        const editModalBody = document.getElementById('editModalBody');
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        
        fetch('<?php echo site_url('user/getEdit'); ?>/' + userID)
            .then(response => response.text())
            .then(data => {
                editModalBody.innerHTML = data;
            })
            .catch(error => {
                editModalBody.innerHTML = '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">Gagal memuat form</div>';
                console.error('Error:', error);
            });
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    function showToast(message, type = 'success', duration = 3500) {
        const toastContainer = document.getElementById('toastContainer');
        
        // Determine colors based on type
        let bgColor, borderColor, textColor, icon;
        switch(type) {
            case 'success':
                bgColor = 'bg-gradient-to-r from-green-50 to-emerald-50';
                borderColor = 'border-green-300';
                textColor = 'text-green-800';
                icon = 'fas fa-check-circle text-green-600';
                break;
            case 'error':
                bgColor = 'bg-gradient-to-r from-red-50 to-pink-50';
                borderColor = 'border-red-300';
                textColor = 'text-red-800';
                icon = 'fas fa-exclamation-circle text-red-600';
                break;
            case 'warning':
                bgColor = 'bg-gradient-to-r from-yellow-50 to-orange-50';
                borderColor = 'border-yellow-300';
                textColor = 'text-yellow-800';
                icon = 'fas fa-exclamation-triangle text-yellow-600';
                break;
            default:
                bgColor = 'bg-gradient-to-r from-blue-50 to-cyan-50';
                borderColor = 'border-blue-300';
                textColor = 'text-blue-800';
                icon = 'fas fa-info-circle text-blue-600';
        }
        
        const toast = document.createElement('div');
        toast.className = `${bgColor} border-2 ${borderColor} ${textColor} px-5 py-4 rounded-lg shadow-lg animate-fade-in flex items-start gap-3 min-w-max max-w-sm`;
        
        toast.innerHTML = `
            <i class="${icon} flex-shrink-0 mt-0.5 text-lg"></i>
            <div class="flex-1">
                <p class="font-semibold text-sm">${message}</p>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="flex-shrink-0 text-xl hover:opacity-70 transition-opacity">
                &times;
            </button>
        `;
        
        toastContainer.appendChild(toast);
        
        // Auto remove after duration
        setTimeout(() => {
            if (toast.parentElement) {
                toast.remove();
            }
        }, duration);
    }

    function showCreateModal() {
        const modal = document.getElementById('createModal');
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        // Reset form
        document.getElementById('createUserForm').reset();
    }

    function submitCreateUser() {
        const username = document.getElementById('create_username');
        const password = document.getElementById('create_password');
        const role = document.getElementById('create_role');
        
        const username_value = username.value.trim();
        const password_value = password.value.trim();
        const role_value = role.value.trim();
        
        // Validasi nilai
        if (!username_value) {
            showToast('Username harus diisi', 'warning');
            username.focus();
            return;
        }
        if (!password_value) {
            showToast('Password harus diisi', 'warning');
            password.focus();
            return;
        }
        if (!role_value) {
            showToast('Role harus dipilih', 'warning');
            role.focus();
            return;
        }
        
        const formData = new FormData();
        formData.append('username', username_value);
        formData.append('password', password_value);
        formData.append('role', role_value);
        
        // Disable button saat submit
        const submitBtn = event.target;
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner animate-spin mr-2"></i> Menyimpan...';
        }
        
        fetch('<?php echo site_url('user/store'); ?>', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('User berhasil ditambahkan!', 'success');
                closeModal('createModal');
                setTimeout(() => location.reload(), 1500);
            } else {
                showToast('Error: ' + (data.message || 'Gagal menyimpan data'), 'error');
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-save mr-2"></i> Simpan';
                }
            }
        })
        .catch(error => {
            showToast('Gagal menyimpan data: ' + error.message, 'error');
            console.error('Error:', error);
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-save mr-2"></i> Simpan';
            }
        });
    }

    function submitEditUser() {
        const form = document.getElementById('editUserForm');
        
        if (!form) {
            showToast('Form tidak ditemukan. Silakan buka modal edit kembali.', 'error');
            return;
        }
        
        const userID = form.getAttribute('data-user-id');
        
        if (!userID) {
            showToast('ID User tidak ditemukan. Silakan buka modal edit kembali.', 'error');
            return;
        }
        
        const username = document.getElementById('username');
        const role = document.getElementById('role');
        const password = document.getElementById('password');
        
        if (!username || !role) {
            showToast('Form tidak lengkap. Silakan buka modal edit kembali.', 'error');
            return;
        }
        
        const username_value = username.value.trim();
        const role_value = role.value.trim();
        const password_value = password ? password.value.trim() : '';
        
        if (!username_value) {
            showToast('Username harus diisi', 'warning');
            username.focus();
            return;
        }
        
        if (!role_value) {
            showToast('Role harus dipilih', 'warning');
            role.focus();
            return;
        }
        
        const formData = new FormData();
        formData.append('username', username_value);
        formData.append('role', role_value);
        if (password_value) {
            formData.append('password', password_value);
        }
        
        // Disable button saat submit
        const submitBtn = event.target || document.querySelector('button[onclick="submitEditUser()"]');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner animate-spin mr-2"></i> Menyimpan...';
        }
        
        fetch('<?php echo site_url('user/update'); ?>/' + userID, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('User berhasil disimpan!', 'success');
                closeModal('editModal');
                setTimeout(() => location.reload(), 1500);
            } else {
                showToast('Error: ' + (data.message || 'Gagal menyimpan data'), 'error');
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-save mr-2"></i> Simpan';
                }
            }
        })
        .catch(error => {
            showToast('Gagal menyimpan data: ' + error.message, 'error');
            console.error('Error:', error);
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-save mr-2"></i> Simpan';
            }
        });
    }

    function showDeleteConfirm(userID, userName) {
        currentUserID = userID;
        document.getElementById('userName').textContent = userName;
        document.getElementById('confirmDeleteModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function confirmDelete() {
        if (!currentUserID) return;
        closeModal('confirmDeleteModal');
        
        fetch('<?php echo site_url('user/delete'); ?>/' + currentUserID, {
            method: 'POST',
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('User berhasil dihapus!', 'success');
                setTimeout(() => location.reload(), 1500);
            } else {
                showToast('Error: ' + (data.message || 'Gagal menghapus data'), 'error');
            }
        })
        .catch(error => {
            showToast('Gagal menghapus data: ' + error.message, 'error');
            console.error('Error:', error);
        });
    }

    // Modal behavior configured - can only close with button clicks
</script>
