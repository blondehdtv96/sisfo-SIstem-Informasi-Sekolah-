# Filter Data Siswa untuk Admin

## Fitur yang Ditambahkan

### 1. Filter Section (Khusus Admin)
**Lokasi**: Sebelum tabel data siswa
**Akses**: Hanya untuk user dengan level admin (id_level_user = 1)

#### Filter Options:
- **Filter Kelas**: Dropdown semua kelas aktif
- **Filter Jurusan**: Dropdown semua jurusan aktif  
- **Filter Status**: Dropdown status siswa (Aktif, Lulus, Pindah, Keluar)

#### Tombol:
- **Filter**: Menerapkan filter yang dipilih
- **Reset**: Menghapus semua filter dan menampilkan semua data

### 2. Controller Updates (application/controllers/Siswa.php)

#### Data untuk Filter
```php
// Get filter options for admin
if ($this->session->userdata('id_level_user') == 1) { // Only for admin
    $data['kelas_list'] = $this->Kelas_model->get_active_with_details();
    $data['jurusan_list'] = $this->Jurusan_model->get_active();
}
```

### 3. View Updates (application/views/siswa/index.php)

#### Filter UI
```html
<!-- Filter Section - Only for Admin -->
<?php if ($this->session->userdata('id_level_user') == 1 && isset($kelas_list)): ?>
<div class="card shadow-sm mb-4">
    <div class="card-header bg-white py-2">
        <h6 class="card-title mb-0 text-dark">
            <i class="fas fa-filter me-2"></i>
            Filter Data Siswa
        </h6>
    </div>
    <div class="card-body py-3">
        <!-- Filter controls -->
    </div>
</div>
<?php endif; ?>
```

#### JavaScript Functionality
```javascript
// Filter functionality for admin
$('#btn_filter').click(function() {
    var kelas = $('#filter_kelas').val();
    var jurusan = $('#filter_jurusan').val();
    var status = $('#filter_status').val();
    
    // Build search string dan apply ke DataTable
    // Show notification dengan Toastr
});

// Auto-filter on select change
$('#filter_kelas, #filter_jurusan, #filter_status').change(function() {
    $('#btn_filter').click();
});
```

## Cara Kerja Filter

### 1. Filter Method
- **Client-side filtering** menggunakan DataTables search
- **Global search** dengan kombinasi terms
- **Real-time filtering** saat dropdown berubah
- **Auto-apply** filter saat user memilih option

### 2. Search Logic
```javascript
// Build search string
var searchTerms = [];
if (kelas) searchTerms.push(kelas);
if (jurusan) searchTerms.push(jurusan);
if (status) searchTerms.push(status);

// Apply global search
var searchString = searchTerms.join(' ');
table.search(searchString).draw();
```

### 3. User Feedback
- **Toastr notifications** untuk filter aktif/reset
- **Visual feedback** dengan highlight hasil filter
- **Filter info** menampilkan filter yang sedang aktif

## Libraries yang Digunakan

### 1. DataTables
- **Built-in search** untuk filtering
- **Responsive design** untuk mobile
- **Pagination** dan sorting

### 2. Toastr
- **Notifications** untuk user feedback
- **Non-intrusive** toast messages
- **Auto-dismiss** dengan timer

### 3. Bootstrap
- **Form controls** untuk filter UI
- **Responsive grid** untuk layout
- **Button groups** untuk actions

## Keuntungan Implementasi

### 1. Performance
- **Client-side filtering** - cepat dan responsive
- **No AJAX requests** - tidak ada loading time
- **Real-time results** - instant feedback

### 2. User Experience
- **Simple interface** - mudah digunakan
- **Auto-apply** - tidak perlu klik filter manual
- **Visual feedback** - notifikasi yang jelas
- **Mobile friendly** - responsive design

### 3. Maintenance
- **Simple code** - mudah di-maintain
- **No server-side logic** - tidak ada kompleksitas backend
- **Reusable** - bisa digunakan di halaman lain

## Akses Control

### Admin Only
```php
<?php if ($this->session->userdata('id_level_user') == 1 && isset($kelas_list)): ?>
    <!-- Filter section -->
<?php endif; ?>
```

### Data Loading
```php
// Get filter options for admin
if ($this->session->userdata('id_level_user') == 1) {
    $data['kelas_list'] = $this->Kelas_model->get_active_with_details();
    $data['jurusan_list'] = $this->Jurusan_model->get_active();
}
```

## Testing Checklist

### Functionality
- [ ] Login sebagai admin - filter muncul
- [ ] Login sebagai non-admin - filter tidak muncul
- [ ] Filter by kelas - hasil sesuai
- [ ] Filter by jurusan - hasil sesuai
- [ ] Filter by status - hasil sesuai
- [ ] Kombinasi filter - hasil sesuai
- [ ] Reset filter - kembali ke semua data
- [ ] Auto-apply saat dropdown berubah

### UI/UX
- [ ] Filter section responsive di mobile
- [ ] Toastr notifications muncul
- [ ] Loading smooth tanpa lag
- [ ] Visual feedback jelas
- [ ] Button states correct

### Performance
- [ ] Filter cepat dan responsive
- [ ] Tidak ada error di console
- [ ] Memory usage normal
- [ ] Mobile performance baik

## Catatan Penting

1. **Admin Only**: Filter hanya muncul untuk admin (level 1)
2. **Client-side**: Menggunakan DataTables search, tidak ada server request
3. **Auto-apply**: Filter otomatis diterapkan saat dropdown berubah
4. **Responsive**: Bekerja baik di desktop dan mobile
5. **Non-intrusive**: Tidak mengganggu functionality yang sudah ada