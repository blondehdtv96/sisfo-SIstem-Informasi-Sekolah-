-- School Management Database Schema
-- Created for managing students, teachers, subjects, and grades

-- Drop existing tables if they exist (in reverse order due to foreign keys)
DROP TABLE IF EXISTS tb_nilai;
DROP TABLE IF EXISTS tb_kelas_siswa;
DROP TABLE IF EXISTS tb_jadwal;
DROP TABLE IF EXISTS tb_siswa;
DROP TABLE IF EXISTS tb_guru;
DROP TABLE IF EXISTS tb_kelas;
DROP TABLE IF EXISTS tb_mata_pelajaran;
DROP TABLE IF EXISTS tb_tahun_akademik;

-- 1. Academic Year Table
CREATE TABLE tb_tahun_akademik (
    id_tahun_akademik INT PRIMARY KEY AUTO_INCREMENT,
    tahun_mulai YEAR NOT NULL,
    tahun_selesai YEAR NOT NULL,
    nama_tahun VARCHAR(20) NOT NULL,
    status ENUM('aktif', 'nonaktif') DEFAULT 'nonaktif',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY unique_tahun (tahun_mulai, tahun_selesai)
);

-- 2. Subject Table
CREATE TABLE tb_mata_pelajaran (
    id_mapel INT PRIMARY KEY AUTO_INCREMENT,
    kode_mapel VARCHAR(10) NOT NULL UNIQUE,
    nama_mapel VARCHAR(100) NOT NULL,
    deskripsi TEXT,
    sks INT DEFAULT 1,
    kategori ENUM('wajib', 'pilihan', 'muatan_lokal') DEFAULT 'wajib',
    status ENUM('aktif', 'nonaktif') DEFAULT 'aktif',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- 3. Class Table
CREATE TABLE tb_kelas (
    id_kelas INT PRIMARY KEY AUTO_INCREMENT,
    nama_kelas VARCHAR(20) NOT NULL,
    tingkat INT NOT NULL,
    jurusan VARCHAR(50),
    kapasitas INT DEFAULT 30,
    status ENUM('aktif', 'nonaktif') DEFAULT 'aktif',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY unique_kelas (nama_kelas, tingkat)
);

-- 4. Teacher Table
CREATE TABLE tb_guru (
    id_guru INT PRIMARY KEY AUTO_INCREMENT,
    nip VARCHAR(20) UNIQUE,
    nama_guru VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE,
    no_telepon VARCHAR(15),
    alamat TEXT,
    tanggal_lahir DATE,
    jenis_kelamin ENUM('L', 'P') NOT NULL,
    pendidikan_terakhir VARCHAR(50),
    mata_pelajaran_utama INT,
    status ENUM('aktif', 'nonaktif', 'cuti') DEFAULT 'aktif',
    tanggal_masuk DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (mata_pelajaran_utama) REFERENCES tb_mata_pelajaran(id_mapel)
);

-- 5. Student Table
CREATE TABLE tb_siswa (
    id_siswa INT PRIMARY KEY AUTO_INCREMENT,
    nis VARCHAR(20) NOT NULL UNIQUE,
    nisn VARCHAR(20) UNIQUE,
    nama_siswa VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    no_telepon VARCHAR(15),
    alamat TEXT,
    tanggal_lahir DATE NOT NULL,
    tempat_lahir VARCHAR(50),
    jenis_kelamin ENUM('L', 'P') NOT NULL,
    agama VARCHAR(20),
    nama_ayah VARCHAR(100),
    nama_ibu VARCHAR(100),
    no_telepon_ortu VARCHAR(15),
    alamat_ortu TEXT,
    tanggal_masuk DATE DEFAULT CURRENT_DATE,
    status ENUM('aktif', 'lulus', 'pindah', 'keluar') DEFAULT 'aktif',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);-- 6
. Student-Class Relationship Table
CREATE TABLE tb_kelas_siswa (
    id_kelas_siswa INT PRIMARY KEY AUTO_INCREMENT,
    id_siswa INT NOT NULL,
    id_kelas INT NOT NULL,
    id_tahun_akademik INT NOT NULL,
    semester ENUM('ganjil', 'genap') NOT NULL,
    status ENUM('aktif', 'pindah', 'keluar') DEFAULT 'aktif',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_siswa) REFERENCES tb_siswa(id_siswa) ON DELETE CASCADE,
    FOREIGN KEY (id_kelas) REFERENCES tb_kelas(id_kelas),
    FOREIGN KEY (id_tahun_akademik) REFERENCES tb_tahun_akademik(id_tahun_akademik),
    UNIQUE KEY unique_siswa_kelas (id_siswa, id_tahun_akademik, semester)
);

-- 7. Schedule Table
CREATE TABLE tb_jadwal (
    id_jadwal INT PRIMARY KEY AUTO_INCREMENT,
    id_kelas INT NOT NULL,
    id_mapel INT NOT NULL,
    id_guru INT NOT NULL,
    id_tahun_akademik INT NOT NULL,
    semester ENUM('ganjil', 'genap') NOT NULL,
    hari ENUM('senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu') NOT NULL,
    jam_mulai TIME NOT NULL,
    jam_selesai TIME NOT NULL,
    ruangan VARCHAR(20),
    status ENUM('aktif', 'nonaktif') DEFAULT 'aktif',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_kelas) REFERENCES tb_kelas(id_kelas),
    FOREIGN KEY (id_mapel) REFERENCES tb_mata_pelajaran(id_mapel),
    FOREIGN KEY (id_guru) REFERENCES tb_guru(id_guru),
    FOREIGN KEY (id_tahun_akademik) REFERENCES tb_tahun_akademik(id_tahun_akademik),
    UNIQUE KEY unique_jadwal (id_kelas, hari, jam_mulai, id_tahun_akademik, semester)
);

-- 8. Grades Table (Fixed version)
CREATE TABLE tb_nilai (
    id_nilai INT PRIMARY KEY AUTO_INCREMENT,
    id_siswa INT NOT NULL,
    id_mapel INT NOT NULL,
    id_tahun_akademik INT NOT NULL,
    semester ENUM('ganjil', 'genap') NOT NULL,
    kategori_nilai ENUM('tugas', 'ulangan_harian', 'uts', 'uas', 'praktek') NOT NULL,
    nilai DECIMAL(5,2) NOT NULL CHECK (nilai >= 0 AND nilai <= 100),
    bobot DECIMAL(3,2) DEFAULT 1.00,
    keterangan TEXT,
    tanggal_input DATE DEFAULT CURRENT_DATE,
    id_guru INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_siswa) REFERENCES tb_siswa(id_siswa) ON DELETE CASCADE,
    FOREIGN KEY (id_mapel) REFERENCES tb_mata_pelajaran(id_mapel),
    FOREIGN KEY (id_tahun_akademik) REFERENCES tb_tahun_akademik(id_tahun_akademik),
    FOREIGN KEY (id_guru) REFERENCES tb_guru(id_guru),
    INDEX idx_siswa_mapel (id_siswa, id_mapel),
    INDEX idx_tahun_semester (id_tahun_akademik, semester)
);

-- Create indexes for better performance
CREATE INDEX idx_siswa_nis ON tb_siswa(nis);
CREATE INDEX idx_guru_nip ON tb_guru(nip);
CREATE INDEX idx_mapel_kode ON tb_mata_pelajaran(kode_mapel);
CREATE INDEX idx_kelas_tingkat ON tb_kelas(tingkat);
CREATE INDEX idx_jadwal_hari ON tb_jadwal(hari, jam_mulai);--
 Sample data insertion
-- Insert Academic Years
INSERT INTO tb_tahun_akademik (tahun_mulai, tahun_selesai, nama_tahun, status) VALUES
(2024, 2025, '2024/2025', 'aktif'),
(2023, 2024, '2023/2024', 'nonaktif'),
(2025, 2026, '2025/2026', 'nonaktif');

-- Insert Subjects
INSERT INTO tb_mata_pelajaran (kode_mapel, nama_mapel, deskripsi, sks, kategori) VALUES
('MTK001', 'Matematika', 'Mata pelajaran matematika dasar', 4, 'wajib'),
('IPA001', 'Fisika', 'Mata pelajaran fisika', 3, 'wajib'),
('IPA002', 'Kimia', 'Mata pelajaran kimia', 3, 'wajib'),
('IPA003', 'Biologi', 'Mata pelajaran biologi', 3, 'wajib'),
('BHS001', 'Bahasa Indonesia', 'Mata pelajaran bahasa Indonesia', 4, 'wajib'),
('BHS002', 'Bahasa Inggris', 'Mata pelajaran bahasa Inggris', 3, 'wajib'),
('IPS001', 'Sejarah', 'Mata pelajaran sejarah', 2, 'wajib'),
('TIK001', 'Informatika', 'Mata pelajaran teknologi informasi', 2, 'pilihan');

-- Insert Classes
INSERT INTO tb_kelas (nama_kelas, tingkat, jurusan, kapasitas) VALUES
('X-IPA-1', 10, 'IPA', 32),
('X-IPA-2', 10, 'IPA', 32),
('X-IPS-1', 10, 'IPS', 30),
('XI-IPA-1', 11, 'IPA', 30),
('XI-IPA-2', 11, 'IPA', 30),
('XI-IPS-1', 11, 'IPS', 28),
('XII-IPA-1', 12, 'IPA', 28),
('XII-IPS-1', 12, 'IPS', 26);

-- Insert Teachers
INSERT INTO tb_guru (nip, nama_guru, email, no_telepon, jenis_kelamin, pendidikan_terakhir, mata_pelajaran_utama, tanggal_masuk) VALUES
('198501012010011001', 'Dr. Ahmad Susanto, S.Pd, M.Pd', 'ahmad.susanto@school.edu', '081234567890', 'L', 'S2 Pendidikan Matematika', 1, '2010-07-01'),
('198703152012022002', 'Siti Nurhaliza, S.Si, M.Pd', 'siti.nurhaliza@school.edu', '081234567891', 'P', 'S2 Pendidikan Fisika', 2, '2012-08-01'),
('199002102015031003', 'Budi Santoso, S.Pd', 'budi.santoso@school.edu', '081234567892', 'L', 'S1 Pendidikan Kimia', 3, '2015-07-15'),
('198812252011012004', 'Rina Kartika, S.Pd, M.Si', 'rina.kartika@school.edu', '081234567893', 'P', 'S2 Biologi', 4, '2011-01-10'),
('199105082014022005', 'Dewi Sartika, S.Pd', 'dewi.sartika@school.edu', '081234567894', 'P', 'S1 Bahasa Indonesia', 5, '2014-07-01');

-- Insert Students
INSERT INTO tb_siswa (nis, nisn, nama_siswa, email, tanggal_lahir, tempat_lahir, jenis_kelamin, agama, nama_ayah, nama_ibu) VALUES
('2024001', '1234567890123456', 'Andi Pratama', 'andi.pratama@student.edu', '2008-03-15', 'Jakarta', 'L', 'Islam', 'Budi Pratama', 'Sari Dewi'),
('2024002', '1234567890123457', 'Sari Indah', 'sari.indah@student.edu', '2008-05-20', 'Bandung', 'P', 'Islam', 'Joko Susilo', 'Rina Sari'),
('2024003', '1234567890123458', 'Rudi Hermawan', 'rudi.hermawan@student.edu', '2008-01-10', 'Surabaya', 'L', 'Kristen', 'Herman Wijaya', 'Lisa Kartika'),
('2024004', '1234567890123459', 'Maya Sari', 'maya.sari@student.edu', '2008-07-25', 'Medan', 'P', 'Hindu', 'Wayan Sutrisna', 'Kadek Sari'),
('2024005', '1234567890123460', 'Doni Setiawan', 'doni.setiawan@student.edu', '2008-09-12', 'Yogyakarta', 'L', 'Islam', 'Setiawan Budi', 'Ani Rahayu');

-- Assign students to classes
INSERT INTO tb_kelas_siswa (id_siswa, id_kelas, id_tahun_akademik, semester) VALUES
(1, 1, 1, 'ganjil'),
(2, 1, 1, 'ganjil'),
(3, 2, 1, 'ganjil'),
(4, 3, 1, 'ganjil'),
(5, 1, 1, 'ganjil');

-- Insert sample grades
INSERT INTO tb_nilai (id_siswa, id_mapel, id_tahun_akademik, semester, kategori_nilai, nilai, bobot, keterangan, id_guru) VALUES
(1, 1, 1, 'ganjil', 'tugas', 85.50, 0.20, 'Tugas Harian 1', 1),
(1, 1, 1, 'ganjil', 'ulangan_harian', 78.00, 0.30, 'Ulangan Harian 1', 1),
(1, 1, 1, 'ganjil', 'uts', 82.75, 0.25, 'Ujian Tengah Semester', 1),
(2, 1, 1, 'ganjil', 'tugas', 90.00, 0.20, 'Tugas Harian 1', 1),
(2, 2, 1, 'ganjil', 'tugas', 88.50, 0.20, 'Tugas Praktikum 1', 2);

-- Create views for easier data access
CREATE VIEW vw_nilai_siswa AS
SELECT 
    s.nis,
    s.nama_siswa,
    mp.nama_mapel,
    ta.nama_tahun,
    n.semester,
    n.kategori_nilai,
    n.nilai,
    n.bobot,
    n.tanggal_input,
    g.nama_guru
FROM tb_nilai n
JOIN tb_siswa s ON n.id_siswa = s.id_siswa
JOIN tb_mata_pelajaran mp ON n.id_mapel = mp.id_mapel
JOIN tb_tahun_akademik ta ON n.id_tahun_akademik = ta.id_tahun_akademik
JOIN tb_guru g ON n.id_guru = g.id_guru
ORDER BY s.nama_siswa, mp.nama_mapel, n.tanggal_input;

CREATE VIEW vw_jadwal_kelas AS
SELECT 
    k.nama_kelas,
    mp.nama_mapel,
    g.nama_guru,
    ta.nama_tahun,
    j.semester,
    j.hari,
    j.jam_mulai,
    j.jam_selesai,
    j.ruangan
FROM tb_jadwal j
JOIN tb_kelas k ON j.id_kelas = k.id_kelas
JOIN tb_mata_pelajaran mp ON j.id_mapel = mp.id_mapel
JOIN tb_guru g ON j.id_guru = g.id_guru
JOIN tb_tahun_akademik ta ON j.id_tahun_akademik = ta.id_tahun_akademik
WHERE j.status = 'aktif'
ORDER BY k.nama_kelas, j.hari, j.jam_mulai;