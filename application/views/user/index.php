<div class="animate-fade-in">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-2xl font-bold text-gray-800">Data User</h3>
        <a href="<?php echo site_url('user/create'); ?>" class="bg-gradient-to-br from-blue-500 to-blue-600 text-white px-4 py-2 rounded-lg hover:shadow-lg transition-all duration-300 hover:-translate-y-0.5">
            <i class="fas fa-plus mr-2"></i> Tambah User
        </a>
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
    }

    function submitEditUser() {
        const userID = editUserID;
        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;
        const role = document.getElementById('role').value;
        
        if (!username || !role) {
            alert('Username dan Role harus diisi');
            return;
        }
        
        const formData = new FormData();
        formData.append('username', username);
        formData.append('password', password);
        formData.append('role', role);
        
        fetch('<?php echo site_url('user/update'); ?>/' + userID, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                closeModal('editModal');
                setTimeout(() => location.reload(), 1500);
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            alert('Gagal menyimpan data');
            console.error('Error:', error);
        });
    }

    function showDeleteConfirm(userID, userName) {
        currentUserID = userID;
        document.getElementById('userName').textContent = userName;
        document.getElementById('confirmDeleteModal').classList.remove('hidden');
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
                setTimeout(() => location.reload(), 1500);
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            alert('Gagal menghapus data');
            console.error('Error:', error);
        });
    }

    document.querySelectorAll('[id$="Modal"]').forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === this) closeModal(this.id);
        });
    });
</script>
