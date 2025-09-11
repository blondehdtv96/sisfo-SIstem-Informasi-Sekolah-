<!-- User Management Page -->
<div class="page-title">
    <h1><i class="fas fa-user-cog me-3"></i>Data User/Admin</h1>
    <p class="subtitle">Kelola akun user dan administrator sistem</p>
</div>

<!-- Action Button -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <button class="btn btn-primary" onclick="location.href='<?php echo base_url('user/add'); ?>'">
            <i class="fas fa-plus me-2"></i>Tambah User Baru
        </button>
    </div>
    <div class="input-group" style="width: 300px;">
        <input type="text" class="form-control" placeholder="Cari user..." id="searchUser">
        <button class="btn btn-outline-secondary" type="button">
            <i class="fas fa-search"></i>
        </button>
    </div>
</div>

<!-- Users Table -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-table me-2"></i>Daftar User & Administrator</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover data-table" id="usersTable">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Nama Lengkap</th>
                        <th>Email</th>
                        <th>No. Telp</th>
                        <th>Level</th>
                        <th>Status</th>
                        <th>Dibuat</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)): ?>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td>
                                    <strong><?php echo htmlspecialchars($user->username); ?></strong>
                                </td>
                                <td><?php echo htmlspecialchars($user->nama_lengkap); ?></td>
                                <td><?php echo $user->email ? htmlspecialchars($user->email) : '<span class="text-muted">-</span>'; ?></td>
                                <td><?php echo $user->no_telp ? htmlspecialchars($user->no_telp) : '<span class="text-muted">-</span>'; ?></td>
                                <td>
                                    <span class="badge bg-info"><?php echo htmlspecialchars($user->nama_level); ?></span>
                                </td>
                                <td>
                                    <?php if ($user->status == 'aktif'): ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        <?php echo date('d/m/Y H:i', strtotime($user->created_at)); ?>
                                    </small>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?php echo base_url('user/edit/' . $user->id_user); ?>" 
                                           class="btn btn-warning btn-sm" title="Edit User">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <?php if ($user->id_user != $this->session->userdata('user_id')): ?>
                                            <button onclick="deleteUser(<?php echo $user->id_user; ?>, '<?php echo htmlspecialchars($user->nama_lengkap); ?>')" 
                                                    class="btn btn-danger btn-sm" title="Hapus User">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-2x mb-3 d-block"></i>
                                Belum ada data user
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mt-4">
    <div class="col-md-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4><?php echo count(array_filter($users, function($u) { return $u->status == 'aktif'; })); ?></h4>
                        <p class="mb-0">User Aktif</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-user-check fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4><?php echo count(array_filter($users, function($u) { return $u->id_level == 1; })); ?></h4>
                        <p class="mb-0">Administrator</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-user-shield fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4><?php echo count(array_filter($users, function($u) { return $u->id_level == 2; })); ?></h4>
                        <p class="mb-0">Wali Kelas</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-user-tie fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4><?php echo count($users); ?></h4>
                        <p class="mb-0">Total User</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function deleteUser(userId, userName) {
    if (confirm('Apakah Anda yakin ingin menghapus user "' + userName + '"?\n\nUser akan dinonaktifkan dari sistem.')) {
        window.location.href = '<?php echo base_url('user/delete/'); ?>' + userId;
    }
}

// Initialize DataTable
$(document).ready(function() {
    $('#usersTable').DataTable({
        "language": {
            "search": "Cari:",
            "lengthMenu": "Tampilkan _MENU_ data per halaman",
            "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            "infoEmpty": "Menampilkan 0 sampai 0 dari 0 data",
            "infoFiltered": "(difilter dari _MAX_ total data)",
            "paginate": {
                "first": "Pertama",
                "last": "Terakhir",
                "next": "Selanjutnya",
                "previous": "Sebelumnya"
            },
            "emptyTable": "Tidak ada data user",
            "zeroRecords": "Tidak ada data yang cocok"
        },
        "pageLength": 25,
        "order": [[6, "desc"]], // Order by created date
        "columnDefs": [
            { "orderable": false, "targets": [7] } // Disable sorting for action column
        ]
    });
    
    // Custom search
    $('#searchUser').on('keyup', function() {
        $('#usersTable').DataTable().search(this.value).draw();
    });
});
</script>