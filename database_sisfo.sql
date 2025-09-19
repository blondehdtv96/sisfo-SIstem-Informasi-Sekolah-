-- ================================================
-- Database: Sistem Informasi Sekolah SMK Bina Mandiri
-- Version: 1.0
-- Created: 2025-09-10
-- ================================================

-- Drop database if exists and create new one
DROP DATABASE IF EXISTS sisfo_smk_bina_mandiri;
CREATE DATABASE sisfo_smk_bina_mandiri;
USE sisfo_smk_bina_mandiri;

-- ================================================
-- 1. MASTER DATA TABLES
-- ================================================

-- Tingkatan Kelas (X, XI, XII)
CREATE TABLE tb_tingkatan (
    id_tingkatan INT PRIMARY KEY AUTO_INCREMENT,
    nama_tingkatan VARCHAR(10) NOT NULL,
    keterangan TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Jurusan
CREATE TABLE tb_jurusan (
    id_jurusan INT PRIMARY KEY AUTO_INCREMENT,
    kode_jurusan VARCHAR(10) NOT NULL UNIQUE,
    nama_jurusan VARCHAR(100) NOT NULL,
    deskripsi TEXT,
    status ENUM('aktif', 'nonaktif') DEFAULT 'aktif',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Mata Pelajaran
CREATE TABLE tb_mata_pelajaran (
    id_mapel INT PRIMARY KEY AUTO_INCREMENT,
    kode_mapel VARCHAR(10) NOT NULL UNIQUE,
    nama_mapel VARCHAR(100) NOT NULL,
    kategori ENUM('umum', 'kejuruan', 'muatan_lokal') DEFAULT 'umum',
    status ENUM('aktif', 'nonaktif') DEFAULT 'aktif',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tahun Akademik
CREATE TABLE tb_tahun_akademik (
    id_tahun_akademik INT PRIMARY KEY AUTO_INCREMENT,
    tahun_ajar VARCHAR(9) NOT NULL, -- Format: 2024/2025
    semester ENUM('ganjil', 'genap') DEFAULT 'ganjil',
    tanggal_mulai DATE NOT NULL,
    tanggal_selesai DATE NOT NULL,
    status ENUM('aktif', 'nonaktif') DEFAULT 'nonaktif',
    keterangan TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Kelas
CREATE TABLE tb_kelas (
    id_kelas INT PRIMARY KEY AUTO_INCREMENT,
    kode_kelas VARCHAR(15) NOT NULL UNIQUE, -- Contoh: XII-RPL-1
    nama_kelas VARCHAR(50) NOT NULL,
    id_tingkatan INT NOT NULL,
    id_jurusan INT NOT NULL,
    kapasitas INT DEFAULT 36,
    status ENUM('aktif', 'nonaktif') DEFAULT 'aktif',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_tingkatan) REFERENCES tb_tingkatan(id_tingkatan),
    FOREIGN KEY (id_jurusan) REFERENCES tb_jurusan(id_jurusan)
);

-- Ruangan
CREATE TABLE tb_ruangan (
    id_ruangan INT PRIMARY KEY AUTO_INCREMENT,
    kode_ruangan VARCHAR(10) NOT NULL UNIQUE,
    nama_ruangan VARCHAR(50) NOT NULL,
    kapasitas INT DEFAULT 40,
    fasilitas TEXT,
    status ENUM('aktif', 'nonaktif') DEFAULT 'aktif',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- ================================================
-- 2. USER MANAGEMENT TABLES
-- ================================================

-- Level User
CREATE TABLE tb_level_user (
    id_level INT PRIMARY KEY AUTO_INCREMENT,
    nama_level VARCHAR(20) NOT NULL,
    deskripsi TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Users/Admin
CREATE TABLE tb_user (
    id_user INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nama_lengkap VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    no_telp VARCHAR(15),
    alamat TEXT,
    foto VARCHAR(255),
    id_level INT NOT NULL,
    status ENUM('aktif', 'nonaktif') DEFAULT 'aktif',
    last_login TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_level) REFERENCES tb_level_user(id_level)
);

-- Guru
CREATE TABLE tb_guru (
    id_guru INT PRIMARY KEY AUTO_INCREMENT,
    nip VARCHAR(20) UNIQUE,
    nuptk VARCHAR(20) UNIQUE,
    nama_guru VARCHAR(100) NOT NULL,
    tempat_lahir VARCHAR(50),
    tanggal_lahir DATE,
    jenis_kelamin ENUM('L', 'P') NOT NULL,
    agama VARCHAR(20),
    alamat TEXT,
    no_telp VARCHAR(15),
    email VARCHAR(100),
    pendidikan_terakhir VARCHAR(50),
    jabatan VARCHAR(50),
    status_kepegawaian ENUM('PNS', 'GTT', 'GTY', 'Honorer') DEFAULT 'GTT',
    username VARCHAR(50) UNIQUE,
    password VARCHAR(255),
    foto VARCHAR(255),
    status ENUM('aktif', 'nonaktif') DEFAULT 'aktif',
    last_login TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Siswa
CREATE TABLE tb_siswa (
    id_siswa INT PRIMARY KEY AUTO_INCREMENT,
    nisn VARCHAR(10) NOT NULL UNIQUE,
    nis VARCHAR(10) UNIQUE,
    nama_siswa VARCHAR(100) NOT NULL,
    tempat_lahir VARCHAR(50),
    tanggal_lahir DATE,
    jenis_kelamin ENUM('L', 'P') NOT NULL,
    agama VARCHAR(20),
    alamat TEXT,
    no_telp VARCHAR(15),
    email VARCHAR(100),
    nama_ayah VARCHAR(100),
    nama_ibu VARCHAR(100),
    pekerjaan_ayah VARCHAR(50),
    pekerjaan_ibu VARCHAR(50),
    no_telp_ortu VARCHAR(15),
    id_kelas INT,
    id_tahun_akademik INT NOT NULL,
    password VARCHAR(255), -- Password untuk login menggunakan NISN
    foto VARCHAR(255),
    status ENUM('aktif', 'pindah', 'lulus', 'keluar') DEFAULT 'aktif',
    tanggal_masuk DATE,
    tanggal_keluar DATE NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_kelas) REFERENCES tb_kelas(id_kelas),
    FOREIGN KEY (id_tahun_akademik) REFERENCES tb_tahun_akademik(id_tahun_akademik)
);

-- Wali Kelas
CREATE TABLE tb_wali_kelas (
    id_wali_kelas INT PRIMARY KEY AUTO_INCREMENT,
    id_guru INT NOT NULL,
    id_kelas INT NOT NULL,
    id_tahun_akademik INT NOT NULL,
    status ENUM('aktif', 'nonaktif') DEFAULT 'aktif',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_guru) REFERENCES tb_guru(id_guru),
    FOREIGN KEY (id_kelas) REFERENCES tb_kelas(id_kelas),
    FOREIGN KEY (id_tahun_akademik) REFERENCES tb_tahun_akademik(id_tahun_akademik),
    UNIQUE KEY unique_wali_kelas (id_kelas, id_tahun_akademik)
);

-- ================================================
-- 3. ACADEMIC TABLES
-- ================================================

-- Guru Mengajar Mata Pelajaran
CREATE TABLE tb_guru_mapel (
    id_guru_mapel INT PRIMARY KEY AUTO_INCREMENT,
    id_guru INT NOT NULL,
    id_mapel INT NOT NULL,
    id_tahun_akademik INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_guru) REFERENCES tb_guru(id_guru),
    FOREIGN KEY (id_mapel) REFERENCES tb_mata_pelajaran(id_mapel),
    FOREIGN KEY (id_tahun_akademik) REFERENCES tb_tahun_akademik(id_tahun_akademik),
    UNIQUE KEY unique_guru_mapel (id_guru, id_mapel, id_tahun_akademik)
);

-- Jadwal Pelajaran
CREATE TABLE tb_jadwal (
    id_jadwal INT PRIMARY KEY AUTO_INCREMENT,
    id_guru INT NOT NULL,
    id_mapel INT NOT NULL,
    id_kelas INT NOT NULL,
    id_ruangan INT NOT NULL,
    id_tahun_akademik INT NOT NULL,
    hari ENUM('Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu') NOT NULL,
    jam_mulai TIME NOT NULL,
    jam_selesai TIME NOT NULL,
    status ENUM('aktif', 'nonaktif') DEFAULT 'aktif',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_guru) REFERENCES tb_guru(id_guru),
    FOREIGN KEY (id_mapel) REFERENCES tb_mata_pelajaran(id_mapel),
    FOREIGN KEY (id_kelas) REFERENCES tb_kelas(id_kelas),
    FOREIGN KEY (id_ruangan) REFERENCES tb_ruangan(id_ruangan),
    FOREIGN KEY (id_tahun_akademik) REFERENCES tb_tahun_akademik(id_tahun_akademik)
);

-- Nilai Siswa
CREATE TABLE tb_nilai (
    id_nilai INT PRIMARY KEY AUTO_INCREMENT,
    id_siswa INT NOT NULL,
    id_mapel INT NOT NULL,
    id_tahun_akademik INT NOT NULL,
    semester ENUM('ganjil', 'genap') NOT NULL,
    kategori_nilai ENUM('tugas', 'ulangan_harian', 'uts', 'uas', 'praktek') NOT NULL,
    nilai DECIMAL(5,2) NOT NULL,
    keterangan TEXT,
    tanggal_input DATE DEFAULT NULL,
    id_guru INT NOT NULL, -- Guru yang menginput nilai
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_siswa) REFERENCES tb_siswa(id_siswa),
    FOREIGN KEY (id_mapel) REFERENCES tb_mata_pelajaran(id_mapel),
    FOREIGN KEY (id_tahun_akademik) REFERENCES tb_tahun_akademik(id_tahun_akademik),
    FOREIGN KEY (id_guru) REFERENCES tb_guru(id_guru)
);

-- ================================================
-- 4. MENU & PERMISSION TABLES
-- ================================================

-- Menu Navigation
CREATE TABLE tb_menu (
    id_menu INT PRIMARY KEY AUTO_INCREMENT,
    nama_menu VARCHAR(50) NOT NULL,
    link VARCHAR(100),
    icon VARCHAR(50),
    parent_id INT DEFAULT 0,
    urutan INT DEFAULT 0,
    status ENUM('aktif', 'nonaktif') DEFAULT 'aktif',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- User Access Rules
CREATE TABLE tb_user_access (
    id_access INT PRIMARY KEY AUTO_INCREMENT,
    id_level INT NOT NULL,
    id_menu INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_level) REFERENCES tb_level_user(id_level),
    FOREIGN KEY (id_menu) REFERENCES tb_menu(id_menu),
    UNIQUE KEY unique_access (id_level, id_menu)
);

-- ================================================
-- 5. INSERT DEFAULT DATA
-- ================================================

-- Insert Level User
INSERT INTO tb_level_user (id_level, nama_level, deskripsi) VALUES
(1, 'Administrator', 'Full access to all system features'),
(2, 'Wali Kelas', 'Access to class management and student monitoring'),
(3, 'Guru', 'Access to teaching materials and grade input'),
(4, 'Siswa', 'Access to view grades and personal information');

-- Insert Default Admin User
INSERT INTO tb_user (username, password, nama_lengkap, email, id_level) VALUES
('admin', MD5('admin123'), 'Administrator', 'admin@smkbinamandiri.sch.id', 1);

-- Insert Tingkatan
INSERT INTO tb_tingkatan (nama_tingkatan, keterangan) VALUES
('X', 'Kelas 10'),
('XI', 'Kelas 11'),
('XII', 'Kelas 12');

-- Insert Jurusan
INSERT INTO tb_jurusan (kode_jurusan, nama_jurusan, deskripsi) VALUES
('RPL', 'Rekayasa Perangkat Lunak', 'Jurusan yang mempelajari pembuatan software dan aplikasi'),
('TKJ', 'Teknik Komputer dan Jaringan', 'Jurusan yang mempelajari hardware komputer dan jaringan'),
('MM', 'Multimedia', 'Jurusan yang mempelajari desain grafis, video, dan animasi'),
('AKL', 'Akuntansi dan Keuangan Lembaga', 'Jurusan yang mempelajari akuntansi dan pengelolaan keuangan'),
('OTKP', 'Otomatisasi dan Tata Kelola Perkantoran', 'Jurusan yang mempelajari administrasi perkantoran modern');

-- Insert Mata Pelajaran Umum
INSERT INTO tb_mata_pelajaran (kode_mapel, nama_mapel, kategori) VALUES
('B.IND', 'Bahasa Indonesia', 'umum'),
('B.ING', 'Bahasa Inggris', 'umum'),
('MTK', 'Matematika', 'umum'),
('IPA', 'Ilmu Pengetahuan Alam', 'umum'),
('IPS', 'Ilmu Pengetahuan Sosial', 'umum'),
('PAI', 'Pendidikan Agama Islam', 'umum'),
('PKN', 'Pendidikan Kewarganegaraan', 'umum'),
('PJOK', 'Pendidikan Jasmani dan Kesehatan', 'umum'),
('SBK', 'Seni Budaya dan Keterampilan', 'umum');

-- Insert Mata Pelajaran Kejuruan RPL
INSERT INTO tb_mata_pelajaran (kode_mapel, nama_mapel, kategori) VALUES
('RPL.01', 'Pemrograman Dasar', 'kejuruan'),
('RPL.02', 'Pemrograman Web', 'kejuruan'),
('RPL.03', 'Basis Data', 'kejuruan'),
('RPL.04', 'Pemrograman Berorientasi Objek', 'kejuruan'),
('RPL.05', 'Rekayasa Perangkat Lunak', 'kejuruan');

-- Insert Mata Pelajaran Kejuruan TKJ
INSERT INTO tb_mata_pelajaran (kode_mapel, nama_mapel, kategori) VALUES
('TKJ.01', 'Sistem Komputer', 'kejuruan'),
('TKJ.02', 'Komputer dan Jaringan Dasar', 'kejuruan'),
('TKJ.03', 'Pemrograman Dasar', 'kejuruan'),
('TKJ.04', 'Dasar Desain Grafis', 'kejuruan'),
('TKJ.05', 'Teknologi Jaringan Berbasis Luas', 'kejuruan');

-- Insert Default Tahun Akademik
INSERT INTO tb_tahun_akademik (tahun_ajar, semester, tanggal_mulai, tanggal_selesai, status) VALUES
('2024/2025', 'ganjil', '2024-07-15', '2024-12-20', 'aktif');

-- Insert Sample Ruangan
INSERT INTO tb_ruangan (kode_ruangan, nama_ruangan, kapasitas) VALUES
('R001', 'Ruang Kelas X RPL 1', 36),
('R002', 'Ruang Kelas X RPL 2', 36),
('R003', 'Ruang Kelas XI RPL 1', 36),
('R004', 'Ruang Kelas XI RPL 2', 36),
('R005', 'Ruang Kelas XII RPL 1', 36),
('LAB01', 'Laboratorium Komputer 1', 40),
('LAB02', 'Laboratorium Komputer 2', 40),
('LAB03', 'Laboratorium Multimedia', 40);

-- Insert Sample Kelas
INSERT INTO tb_kelas (kode_kelas, nama_kelas, id_tingkatan, id_jurusan) VALUES
('X-RPL-1', 'X RPL 1', 1, 1),
('X-RPL-2', 'X RPL 2', 1, 1),
('XI-RPL-1', 'XI RPL 1', 2, 1),
('XI-RPL-2', 'XI RPL 2', 2, 1),
('XII-RPL-1', 'XII RPL 1', 3, 1),
('X-TKJ-1', 'X TKJ 1', 1, 2),
('XI-TKJ-1', 'XI TKJ 1', 2, 2),
('XII-TKJ-1', 'XII TKJ 1', 3, 2);

-- Insert Sample Guru Data
INSERT INTO tb_guru (nip, nama_guru, jenis_kelamin, jabatan, status_kepegawaian, username, password) VALUES
('196801011990031001', 'Drs. Ahmad Supriyadi, M.Pd', 'L', 'Kepala Sekolah', 'PNS', 'ahmad.supriyadi', MD5('guru123')),
('197205101998022001', 'Siti Nurjanah, S.Kom', 'P', 'Guru RPL', 'PNS', 'siti.nurjanah', MD5('guru123')),
('198003152005011002', 'Budi Santoso, S.T', 'L', 'Guru TKJ', 'PNS', 'budi.santoso', MD5('guru123')),
('198506201010122003', 'Maya Sari, S.Pd', 'P', 'Guru Multimedia', 'GTT', 'maya.sari', MD5('guru123')),
('199001051015013004', 'Eko Prasetyo, S.Kom', 'L', 'Guru RPL', 'GTT', 'eko.prasetyo', MD5('guru123')),
('198712122012022005', 'Rina Wati, S.Pd', 'P', 'Guru Bahasa Inggris', 'PNS', 'rina.wati', MD5('guru123')),
('199203101017013006', 'Agus Setiawan, S.Pd', 'L', 'Guru Matematika', 'GTT', 'agus.setiawan', MD5('guru123')),
('198908152014022007', 'Fitri Handayani, S.Pd', 'P', 'Guru Bahasa Indonesia', 'PNS', 'fitri.handayani', MD5('guru123'));

-- Insert Sample Siswa Data
INSERT INTO tb_siswa (nisn, nis, nama_siswa, tempat_lahir, tanggal_lahir, jenis_kelamin, agama, alamat, no_telp, nama_ayah, nama_ibu, id_kelas, id_tahun_akademik, password, tanggal_masuk) VALUES
('0071234567', '2024001', 'Ahmad Rizki Pratama', 'Jakarta', '2007-05-15', 'L', 'Islam', 'Jl. Raya No. 123, Jakarta', '081234567001', 'Budi Pratama', 'Siti Aminah', 1, 1, MD5('siswa123'), '2024-07-15'),
('0071234568', '2024002', 'Siti Aisyah Putri', 'Bogor', '2007-08-20', 'P', 'Islam', 'Jl. Sudirman No. 456, Bogor', '081234567002', 'Hendra Gunawan', 'Eka Sari', 1, 1, MD5('siswa123'), '2024-07-15'),
('0071234569', '2024003', 'Muhammad Farhan', 'Depok', '2007-03-10', 'L', 'Islam', 'Jl. Margonda No. 789, Depok', '081234567003', 'Dedi Kurniawan', 'Ria Melati', 1, 1, MD5('siswa123'), '2024-07-15'),
('0071234570', '2024004', 'Indira Safitri', 'Tangerang', '2007-11-25', 'P', 'Islam', 'Jl. BSD No. 321, Tangerang', '081234567004', 'Joko Susilo', 'Dewi Lestari', 1, 1, MD5('siswa123'), '2024-07-15'),
('0071234571', '2024005', 'Andi Pratama', 'Bekasi', '2007-09-18', 'L', 'Islam', 'Jl. Kalimalang No. 654, Bekasi', '081234567005', 'Andi Maulana', 'Sri Wahyuni', 2, 1, MD5('siswa123'), '2024-07-15'),
('0061234567', '2023001', 'Nadia Putri Utami', 'Jakarta', '2006-12-05', 'P', 'Islam', 'Jl. Kemang No. 111, Jakarta', '081234567006', 'Utomo Setiawan', 'Nining Kusuma', 3, 1, MD5('siswa123'), '2023-07-15'),
('0061234568', '2023002', 'Dimas Aditya Putra', 'Bogor', '2006-04-22', 'L', 'Kristen', 'Jl. Pajajaran No. 222, Bogor', '081234567007', 'Bambang Aditya', 'Sari Indah', 3, 1, MD5('siswa123'), '2023-07-15'),
('0061234569', '2023003', 'Lestari Wulandari', 'Depok', '2006-07-30', 'P', 'Islam', 'Jl. UI No. 333, Depok', '081234567008', 'Wawan Sutrisno', 'Lina Sari', 4, 1, MD5('siswa123'), '2023-07-15'),
('0051234567', '2022001', 'Ryan Hidayat', 'Jakarta', '2005-01-15', 'L', 'Islam', 'Jl. Senayan No. 444, Jakarta', '081234567009', 'Hidayat Rahman', 'Maya Sari', 5, 1, MD5('siswa123'), '2022-07-15'),
('0051234568', '2022002', 'Putri Maharani', 'Tangerang', '2005-06-28', 'P', 'Islam', 'Jl. Alam Sutera No. 555, Tangerang', '081234567010', 'Maharani Putra', 'Dewi Sartika', 5, 1, MD5('siswa123'), '2022-07-15'),
('0071234572', '2024006', 'Bayu Setiawan', 'Jakarta', '2007-02-14', 'L', 'Islam', 'Jl. Gatot Subroto No. 666, Jakarta', '081234567011', 'Setiawan Budi', 'Ratna Sari', 6, 1, MD5('siswa123'), '2024-07-15'),
('0071234573', '2024007', 'Citra Dewi', 'Bogor', '2007-10-03', 'P', 'Islam', 'Jl. Bogor Raya No. 777, Bogor', '081234567012', 'Dewi Santoso', 'Citra Wati', 6, 1, MD5('siswa123'), '2024-07-15'),
('0061234570', '2023004', 'Rifki Aditama', 'Depok', '2006-09-12', 'L', 'Islam', 'Jl. Depok Raya No. 888, Depok', '081234567013', 'Aditama Putra', 'Rika Sari', 7, 1, MD5('siswa123'), '2023-07-15'),
('0051234569', '2022003', 'Sinta Purnama', 'Jakarta', '2005-11-08', 'P', 'Kristen', 'Jl. Kuningan No. 999, Jakarta', '081234567014', 'Purnama Jaya', 'Sinta Dewi', 8, 1, MD5('siswa123'), '2022-07-15'),
('0071234574', '2024008', 'David Christian', 'Bekasi', '2007-04-16', 'L', 'Kristen', 'Jl. Bekasi Timur No. 101, Bekasi', '081234567015', 'Christian David', 'Maria Sari', 1, 1, MD5('siswa123'), '2024-07-15'),
('0071234575', '2024009', 'Jessica Tania', 'Tangerang', '2007-12-07', 'P', 'Kristen', 'Jl. Serpong No. 202, Tangerang', '081234567016', 'Tania Kusuma', 'Jessica Lim', 2, 1, MD5('siswa123'), '2024-07-15'),
('0061234571', '2023005', 'Faisal Rahman', 'Jakarta', '2006-03-21', 'L', 'Islam', 'Jl. Cempaka Putih No. 303, Jakarta', '081234567017', 'Rahman Hakim', 'Faizah Sari', 3, 1, MD5('siswa123'), '2023-07-15'),
('0061234572', '2023006', 'Anisa Rahmawati', 'Bogor', '2006-08-14', 'P', 'Islam', 'Jl. Bogor Baru No. 404, Bogor', '081234567018', 'Rahmawati Usman', 'Anisa Dewi', 4, 1, MD5('siswa123'), '2023-07-15'),
('0051234570', '2022004', 'Kevin Alexander', 'Depok', '2005-05-09', 'L', 'Kristen', 'Jl. Lenteng Agung No. 505, Depok', '081234567019', 'Alexander King', 'Kevin Maria', 5, 1, MD5('siswa123'), '2022-07-15'),
('0051234571', '2022005', 'Natasha Putri', 'Bekasi', '2005-10-02', 'P', 'Kristen', 'Jl. Bekasi Barat No. 606, Bekasi', '081234567020', 'Putri Agung', 'Natasha Indah', 5, 1, MD5('siswa123'), '2022-07-15');

-- Insert Sample Wali Kelas
INSERT INTO tb_wali_kelas (id_guru, id_kelas, id_tahun_akademik) VALUES
(2, 1, 1), -- Siti Nurjanah mengajar X RPL 1
(3, 2, 1), -- Budi Santoso mengajar X RPL 2
(4, 3, 1), -- Maya Sari mengajar XI RPL 1
(5, 4, 1), -- Eko Prasetyo mengajar XI RPL 2
(6, 5, 1), -- Rina Wati mengajar XII RPL 1
(7, 6, 1), -- Agus Setiawan mengajar X TKJ 1
(8, 7, 1), -- Fitri Handayani mengajar XI TKJ 1
(2, 8, 1); -- Siti Nurjanah mengajar XII TKJ 1

-- Insert Sample Guru Mapel
INSERT INTO tb_guru_mapel (id_guru, id_mapel, id_tahun_akademik) VALUES
(2, 10, 1), -- Siti Nurjanah mengajar Pemrograman Dasar
(2, 11, 1), -- Siti Nurjanah mengajar Pemrograman Web
(3, 15, 1), -- Budi Santoso mengajar Sistem Komputer
(3, 16, 1), -- Budi Santoso mengajar Komputer dan Jaringan Dasar
(4, 18, 1), -- Maya Sari mengajar Dasar Desain Grafis
(5, 12, 1), -- Eko Prasetyo mengajar Basis Data
(5, 13, 1), -- Eko Prasetyo mengajar Pemrograman Berorientasi Objek
(6, 2, 1),  -- Rina Wati mengajar Bahasa Inggris
(7, 3, 1),  -- Agus Setiawan mengajar Matematika
(8, 1, 1);  -- Fitri Handayani mengajar Bahasa Indonesia

-- Insert Menu Structure
INSERT INTO tb_menu (id_menu, nama_menu, link, icon, parent_id, urutan) VALUES
(1, 'Dashboard', 'dashboard', 'fas fa-tachometer-alt', 0, 1),
(2, 'Master Data', '#', 'fas fa-database', 0, 2),
(3, 'Data Mata Pelajaran', 'mata_pelajaran', 'fas fa-book', 2, 1),
(4, 'Data Tingkatan', 'tingkatan', 'fas fa-layer-group', 2, 2),
(5, 'Data Jurusan', 'jurusan', 'fas fa-graduation-cap', 2, 3),
(6, 'Data Kelas', 'kelas', 'fas fa-users', 2, 4),
(7, 'Data Tahun Ajar', 'tahun_akademik', 'fas fa-calendar', 2, 5),
(8, 'Manajemen Data', '#', 'fas fa-folder-open', 0, 3),
(9, 'Data Siswa', 'siswa', 'fas fa-user-graduate', 8, 1),
(10, 'Data Guru', 'guru', 'fas fa-chalkboard-teacher', 8, 2),
(11, 'Data Wali Kelas', 'wali_kelas', 'fas fa-user-tie', 8, 3),
(12, 'Data User/Admin', 'user', 'fas fa-user-cog', 8, 4),
(13, 'Laporan', '#', 'fas fa-file-alt', 0, 4),
(14, 'Cetak Data Siswa', 'laporan/siswa', 'fas fa-print', 13, 1),
(15, 'Cetak Data Guru', 'laporan/guru', 'fas fa-print', 13, 2),
(16, 'Cetak Kelas & Wali Kelas', 'laporan/kelas', 'fas fa-print', 13, 3),
(17, 'Pengaturan', '#', 'fas fa-cog', 0, 5),
(18, 'Profile User', 'profile', 'fas fa-user-edit', 17, 1),
(19, 'Ubah Password', 'change_password', 'fas fa-key', 17, 2);

-- Insert User Access Rights
-- Admin (Level 1) - Full Access
INSERT INTO tb_user_access (id_level, id_menu) VALUES
(1, 1), (1, 2), (1, 3), (1, 4), (1, 5), (1, 6), (1, 7), (1, 8), (1, 9), (1, 10), (1, 11), (1, 12), (1, 13), (1, 14), (1, 15), (1, 16), (1, 17), (1, 18), (1, 19);

-- Wali Kelas (Level 2)
INSERT INTO tb_user_access (id_level, id_menu) VALUES
(2, 1), (2, 9), (2, 13), (2, 14), (2, 17), (2, 18), (2, 19);

-- Guru (Level 3)
INSERT INTO tb_user_access (id_level, id_menu) VALUES
(3, 1), (3, 9), (3, 17), (3, 18), (3, 19);

-- Siswa (Level 4)
INSERT INTO tb_user_access (id_level, id_menu) VALUES
(4, 1), (4, 17), (4, 18), (4, 19);

-- ================================================
-- 6. CREATE VIEWS FOR REPORTING
-- ================================================

-- View untuk laporan siswa per kelas
CREATE VIEW v_siswa_kelas AS
SELECT 
    s.id_siswa,
    s.nisn,
    s.nis,
    s.nama_siswa,
    s.jenis_kelamin,
    s.tempat_lahir,
    s.tanggal_lahir,
    k.nama_kelas,
    j.nama_jurusan,
    t.nama_tingkatan,
    ta.tahun_ajar,
    s.status,
    s.created_at
FROM tb_siswa s
LEFT JOIN tb_kelas k ON s.id_kelas = k.id_kelas
LEFT JOIN tb_jurusan j ON k.id_jurusan = j.id_jurusan
LEFT JOIN tb_tingkatan t ON k.id_tingkatan = t.id_tingkatan
LEFT JOIN tb_tahun_akademik ta ON s.id_tahun_akademik = ta.id_tahun_akademik;

-- View untuk laporan guru dan mata pelajaran
CREATE VIEW v_guru_mapel AS
SELECT 
    g.id_guru,
    g.nip,
    g.nama_guru,
    g.jabatan,
    g.status_kepegawaian,
    GROUP_CONCAT(m.nama_mapel SEPARATOR ', ') as mata_pelajaran,
    ta.tahun_ajar
FROM tb_guru g
LEFT JOIN tb_guru_mapel gm ON g.id_guru = gm.id_guru
LEFT JOIN tb_mata_pelajaran m ON gm.id_mapel = m.id_mapel
LEFT JOIN tb_tahun_akademik ta ON gm.id_tahun_akademik = ta.id_tahun_akademik
GROUP BY g.id_guru, ta.tahun_ajar;

-- View untuk laporan wali kelas
CREATE VIEW v_wali_kelas AS
SELECT 
    wk.id_wali_kelas,
    g.nama_guru,
    g.nip,
    k.nama_kelas,
    j.nama_jurusan,
    t.nama_tingkatan,
    ta.tahun_ajar,
    COUNT(s.id_siswa) as jumlah_siswa
FROM tb_wali_kelas wk
JOIN tb_guru g ON wk.id_guru = g.id_guru
JOIN tb_kelas k ON wk.id_kelas = k.id_kelas
JOIN tb_jurusan j ON k.id_jurusan = j.id_jurusan
JOIN tb_tingkatan t ON k.id_tingkatan = t.id_tingkatan
JOIN tb_tahun_akademik ta ON wk.id_tahun_akademik = ta.id_tahun_akademik
LEFT JOIN tb_siswa s ON k.id_kelas = s.id_kelas AND s.status = 'aktif'
GROUP BY wk.id_wali_kelas;

-- ================================================
-- 7. CREATE INDEXES FOR PERFORMANCE
-- ================================================

CREATE INDEX idx_siswa_nisn ON tb_siswa(nisn);
CREATE INDEX idx_siswa_status ON tb_siswa(status);
CREATE INDEX idx_guru_nip ON tb_guru(nip);
CREATE INDEX idx_guru_username ON tb_guru(username);
CREATE INDEX idx_nilai_siswa_mapel ON tb_nilai(id_siswa, id_mapel);
CREATE INDEX idx_jadwal_kelas_hari ON tb_jadwal(id_kelas, hari);

-- ================================================
-- 8. TRIGGERS FOR AUTO DATE AND AUDIT LOG
-- ================================================

-- Trigger to set tanggal_input automatically
DELIMITER $$
CREATE TRIGGER tr_nilai_before_insert 
BEFORE INSERT ON tb_nilai
FOR EACH ROW
BEGIN
    IF NEW.tanggal_input IS NULL THEN
        SET NEW.tanggal_input = CURDATE();
    END IF;
END$$
DELIMITER ;

-- ================================================
-- 9. TRIGGERS FOR AUDIT LOG
-- ================================================

CREATE TABLE tb_audit_log (
    id_log INT PRIMARY KEY AUTO_INCREMENT,
    table_name VARCHAR(50) NOT NULL,
    operation ENUM('INSERT', 'UPDATE', 'DELETE') NOT NULL,
    user_id INT,
    old_values TEXT,
    new_values TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ================================================
-- END OF DATABASE SCHEMA
-- ================================================