<div class="d-flex justify-content-between align-items-center mb-4">
    <h3>Data User</h3>
    <a href="<?php echo site_url('user/create'); ?>" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah User
    </a>
</div>

<style>
    /* Styling untuk table action column */
    .table-actions {
        text-align: right;
        white-space: nowrap;
        padding-right: 15px !important;
    }
    
    .table-actions .btn {
        margin-left: 5px;
        margin-right: 0;
        padding: 0.375rem 0.65rem;
        font-size: 0.875rem;
    }
    
    .table thead th:last-child {
        text-align: right;
        padding-right: 15px !important;
    }
    
    /* Responsive action buttons */
    @media (max-width: 768px) {
        .table-actions {
            display: flex;
            flex-direction: column;
            gap: 5px;
            padding-right: 10px !important;
        }
        
        .table-actions .btn {
            width: 100%;
            margin-left: 0;
            text-align: center;
        }
    }
</style>

<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i> <?php echo $this->session->flashdata('success'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle"></i> <?php echo $this->session->flashdata('error'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Username</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($users)): ?>
                <tr>
                    <td colspan="4" class="text-center">Tidak ada data user</td>
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
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $user->Username; ?></td>
                    <td>
                        <span class="badge <?php echo $user->Role == 'admin' ? 'bg-danger' : 'bg-success'; ?>">
                            <?php echo ucfirst($user->Role); ?>
                        </span>
                    </td>
                    <td class="table-actions">
                        <button type="button" class="btn btn-sm btn-info" onclick="showDetailModal(<?php echo $user->UserID; ?>)" title="Lihat Detail">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-warning" onclick="showEditModal(<?php echo $user->UserID; ?>)" title="Edit User">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-danger" onclick="showDeleteConfirm(<?php echo $user->UserID; ?>, '<?php echo addslashes($user->Username); ?>')" title="Hapus User">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Pagination -->
<?php if (!empty($users) && $total_pages > 1): ?>
<nav aria-label="Pagination">
    <ul class="pagination justify-content-center">
        <?php if ($page > 1): ?>
        <li class="page-item">
            <a class="page-link" href="<?php echo site_url('user?page=' . ($page - 1)); ?>">
                <i class="fas fa-chevron-left"></i> Sebelumnya
            </a>
        </li>
        <?php else: ?>
        <li class="page-item disabled">
            <span class="page-link"><i class="fas fa-chevron-left"></i> Sebelumnya</span>
        </li>
        <?php endif; ?>
        
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
            <a class="page-link" href="<?php echo site_url('user?page=' . $i); ?>">
                <?php echo $i; ?>
            </a>
        </li>
        <?php endfor; ?>
        
        <?php if ($page < $total_pages): ?>
        <li class="page-item">
            <a class="page-link" href="<?php echo site_url('user?page=' . ($page + 1)); ?>">
                Selanjutnya <i class="fas fa-chevron-right"></i>
            </a>
        </li>
        <?php else: ?>
        <li class="page-item disabled">
            <span class="page-link">Selanjutnya <i class="fas fa-chevron-right"></i></span>
        </li>
        <?php endif; ?>
    </ul>
</nav>
<?php endif; ?>

<!-- Modal Detail User -->
<div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="modalBody">
                <div class="text-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit User -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="editModalBody">
                <div class="text-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="submitEditUser()">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Delete -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-danger">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="fas fa-exclamation-triangle"></i> Konfirmasi Hapus</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus user ini?</p>
                <p id="deleteInfo" class="text-muted"><small>Username: <strong id="userName"></strong></small></p>
                <p class="text-muted"><small>Tindakan ini tidak dapat dibatalkan.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" onclick="confirmDelete()">
                    <i class="fas fa-trash"></i> Ya, Hapus
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let currentUserID = null;
    let editUserID = null;

    function showDetailModal(userID) {
        const modal = new bootstrap.Modal(document.getElementById('detailModal'));
        const modalBody = document.getElementById('modalBody');
        
        // Load detail via AJAX
        fetch('<?php echo site_url('user/getDetail'); ?>/' + userID)
            .then(response => response.text())
            .then(data => {
                modalBody.innerHTML = data;
            })
            .catch(error => {
                modalBody.innerHTML = '<div class="alert alert-danger">Gagal memuat data</div>';
                console.error('Error:', error);
            });
        
        modal.show();
    }

    function showEditModal(userID) {
        editUserID = userID;
        const modal = new bootstrap.Modal(document.getElementById('editModal'));
        const editModalBody = document.getElementById('editModalBody');
        
        // Load edit form via AJAX
        fetch('<?php echo site_url('user/getEdit'); ?>/' + userID)
            .then(response => response.text())
            .then(data => {
                editModalBody.innerHTML = data;
            })
            .catch(error => {
                editModalBody.innerHTML = '<div class="alert alert-danger">Gagal memuat form</div>';
                console.error('Error:', error);
            });
        
        modal.show();
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
                bootstrap.Modal.getInstance(document.getElementById('editModal')).hide();
                
                // Tampilkan success alert
                const alertDiv = document.createElement('div');
                alertDiv.className = 'alert alert-success alert-dismissible fade show';
                alertDiv.innerHTML = `
                    <i class="fas fa-check-circle"></i> ${data.message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                document.body.insertBefore(alertDiv, document.body.firstChild);
                
                // Reload setelah 1.5 detik
                setTimeout(() => {
                    location.reload();
                }, 1500);
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
        
        const confirmModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
        confirmModal.show();
    }

    function confirmDelete() {
        if (!currentUserID) return;
        
        // Tutup modal
        bootstrap.Modal.getInstance(document.getElementById('confirmDeleteModal')).hide();
        
        fetch('<?php echo site_url('user/delete'); ?>/' + currentUserID, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Tampilkan success alert
                const alertDiv = document.createElement('div');
                alertDiv.className = 'alert alert-success alert-dismissible fade show';
                alertDiv.innerHTML = `
                    <i class="fas fa-check-circle"></i> ${data.message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                document.body.insertBefore(alertDiv, document.body.firstChild);
                
                // Reload setelah 1.5 detik
                setTimeout(() => {
                    location.reload();
                }, 1500);
            } else {
                // Tampilkan error alert
                const alertDiv = document.createElement('div');
                alertDiv.className = 'alert alert-danger alert-dismissible fade show';
                alertDiv.innerHTML = `
                    <i class="fas fa-exclamation-circle"></i> Error: ${data.message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                document.body.insertBefore(alertDiv, document.body.firstChild);
            }
        })
        .catch(error => {
            // Tampilkan error alert
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-danger alert-dismissible fade show';
            alertDiv.innerHTML = `
                <i class="fas fa-exclamation-circle"></i> Gagal menghapus data
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            document.body.insertBefore(alertDiv, document.body.firstChild);
            console.error('Error:', error);
        });
    }
</script>

