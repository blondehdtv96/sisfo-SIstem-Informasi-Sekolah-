# SISFO SMK Bina Mandiri
## Sistem Informasi Sekolah SMK Bina Mandiri

### Deskripsi Sistem
SISFO SMK Bina Mandiri adalah sistem informasi sekolah berbasis web yang dibangun menggunakan framework CodeIgniter 3. Sistem ini dirancang untuk mengelola data akademik sekolah menengah kejuruan meliputi manajemen siswa, guru, kelas, nilai, dan laporan.

### Teknologi yang Digunakan
- **Backend Framework**: CodeIgniter 3.x
- **Database**: MySQL 
- **Frontend**: Bootstrap 5, HTML5, CSS3, JavaScript
- **Library**: FPDF (PDF Generation), Chart.js (Visualisasi Data)
- **Server**: Apache (XAMPP)
- **Bahasa Pemrograman**: PHP 7.2+

---

## Diagram Aktivitas Sistem (Activity Diagram)

### 1. Diagram Aktivitas Login Sistem

```mermaid
flowchart TD
    A[Pengguna Mengakses Sistem] --> B{Sudah Login?}
    B -->|Ya| C[Redirect ke Dashboard]
    B -->|Tidak| D[Tampilkan Form Login]
    D --> E[Input Username/NISN & Password]
    E --> F{Validasi Input}
    F -->|Gagal| G[Tampilkan Pesan Error]
    G --> D
    F -->|Berhasil| H{Cek Tipe User}
    H -->|NISN Siswa| I[Autentikasi Siswa]
    H -->|Username Admin/User| J[Autentikasi Admin/User]
    H -->|Username Guru| K[Autentikasi Guru]
    I --> L{Login Berhasil?}
    J --> L
    K --> L
    L -->|Gagal| M[Tampilkan Error Login]
    M --> D
    L -->|Berhasil| N[Set Session User]
    N --> O[Update Last Login]
    O --> P[Redirect ke Dashboard]
    P --> Q[Tampilkan Dashboard Sesuai Level]
```

### 2. Diagram Aktivitas Manajemen Data Siswa

```mermaid
flowchart TD
    A[Admin/Wali Kelas Akses Menu Siswa] --> B[Tampilkan Daftar Siswa]
    B --> C{Pilih Aksi}
    C -->|Tambah| D[Form Input Siswa Baru]
    C -->|Edit| E[Form Edit Data Siswa]
    C -->|Hapus| F[Konfirmasi Hapus]
    C -->|Lihat Detail| G[Tampilkan Detail Siswa]
    
    D --> H[Input Data Siswa]
    H --> I{Validasi Data}
    I -->|Gagal| J[Tampilkan Error Validasi]
    J --> D
    I -->|Berhasil| K[Simpan ke Database]
    K --> L[Tampilkan Pesan Sukses]
    L --> B
    
    E --> M[Load Data Siswa]
    M --> N[Edit Data Siswa]
    N --> O{Validasi Data}
    O -->|Gagal| P[Tampilkan Error Validasi]
    P --> E
    O -->|Berhasil| Q[Update Database]
    Q --> R[Tampilkan Pesan Sukses]
    R --> B
```

---

## Diagram Urutan (Sequence Diagram)

### 1. Sequence Diagram Proses Login

```mermaid
sequenceDiagram
    participant U as User
    participant C as Auth Controller
    participant M as Auth Model
    participant D as Database
    participant S as Session

    U->>C: Akses halaman login
    C->>U: Tampilkan form login
    U->>C: Submit username & password
    C->>C: Validasi input form
    alt Input valid
        C->>M: Panggil fungsi login
        M->>D: Query user berdasarkan username/NISN
        D->>M: Return data user
        alt User ditemukan
            M->>M: Verifikasi password
            alt Password benar
                M->>D: Update last_login
                M->>C: Return data user
                C->>S: Set session data
                C->>U: Redirect ke dashboard
            else Password salah
                M->>C: Return false
                C->>U: Tampilkan error login
            end
        else User tidak ditemukan
            M->>C: Return false
            C->>U: Tampilkan error login
        end
    else Input tidak valid
        C->>U: Tampilkan error validasi
    end
```

### 2. Sequence Diagram CRUD Data Siswa

```mermaid
sequenceDiagram
    participant A as Admin
    participant C as Siswa Controller
    participant M as Siswa Model
    participant V as Validation
    participant D as Database

    A->>C: Akses menu siswa
    C->>M: get_all_with_details()
    M->>D: Query siswa dengan join
    D->>M: Return data siswa
    M->>C: Return hasil query
    C->>A: Tampilkan daftar siswa

    A->>C: Klik tambah siswa
    C->>A: Tampilkan form input

    A->>C: Submit data siswa baru
    C->>V: Validasi input
    alt Validasi berhasil
        C->>M: insert(data)
        M->>D: INSERT INTO tb_siswa
        D->>M: Return insert ID
        M->>C: Return success
        C->>A: Redirect dengan pesan sukses
    else Validasi gagal
        C->>A: Tampilkan error validasi
    end
```

---

## Diagram Alir Sistem (Flowchart)

### Flowchart Sistem Keseluruhan

```mermaid
flowchart TD
    A[Start - Akses Sistem] --> B{User Sudah Login?}
    B -->|Tidak| C[Halaman Login]
    C --> D[Input Kredensial]
    D --> E{Validasi Login}
    E -->|Gagal| F[Tampilkan Error]
    F --> C
    E -->|Berhasil| G[Set Session]
    
    B -->|Ya| G
    G --> H{Cek Level User}
    
    H -->|Level 1 - Admin| I[Dashboard Admin]
    H -->|Level 2 - Wali Kelas| J[Dashboard Wali Kelas]
    H -->|Level 3 - Guru| K[Dashboard Guru]
    H -->|Level 4 - Siswa| L[Dashboard Siswa]
    
    I --> M[Menu Admin:<br/>- Master Data<br/>- Manajemen Data<br/>- Laporan<br/>- Pengaturan]
    J --> N[Menu Wali Kelas:<br/>- Data Siswa<br/>- Laporan<br/>- Pengaturan]
    K --> O[Menu Guru:<br/>- Data Siswa<br/>- Input Nilai<br/>- Pengaturan]
    L --> P[Menu Siswa:<br/>- Jadwal<br/>- Nilai<br/>- Biodata<br/>- Pengaturan]
    
    M --> Q{Pilih Menu}
    N --> Q
    O --> Q
    P --> Q
    
    Q -->|Master Data| R[Kelola:<br/>- Mata Pelajaran<br/>- Tingkatan<br/>- Jurusan<br/>- Kelas<br/>- Tahun Ajar]
    Q -->|Manajemen Data| S[Kelola:<br/>- Siswa<br/>- Guru<br/>- Wali Kelas<br/>- User Admin]
    Q -->|Laporan| T[Generate:<br/>- Laporan Siswa<br/>- Laporan Guru<br/>- Laporan Kelas]
    Q -->|Logout| U[Hapus Session]
    
    R --> V[CRUD Operations]
    S --> V
    T --> W[Export PDF/Excel]
    U --> X[Redirect ke Login]
    
    V --> Y[Kembali ke Menu]
    W --> Y
    Y --> Q
    X --> Z[End]
```

---

## Diagram Hubungan Entitas (ERD)

```mermaid
erDiagram
    tb_level_user {
        int id_level PK
        varchar nama_level
        text deskripsi
        timestamp created_at
    }
    
    tb_user {
        int id_user PK
        varchar username UK
        varchar password
        varchar nama_lengkap
        varchar email
        int id_level FK
        enum status
        timestamp created_at
    }
    
    tb_tingkatan {
        int id_tingkatan PK
        varchar nama_tingkatan
        text keterangan
        timestamp created_at
    }
    
    tb_jurusan {
        int id_jurusan PK
        varchar kode_jurusan UK
        varchar nama_jurusan
        text deskripsi
        enum status
        timestamp created_at
    }
    
    tb_mata_pelajaran {
        int id_mapel PK
        varchar kode_mapel UK
        varchar nama_mapel
        enum kategori
        enum status
        timestamp created_at
    }
    
    tb_tahun_akademik {
        int id_tahun_akademik PK
        varchar tahun_ajar
        enum semester
        date tanggal_mulai
        date tanggal_selesai
        enum status
        timestamp created_at
    }
    
    tb_kelas {
        int id_kelas PK
        varchar kode_kelas UK
        varchar nama_kelas
        int id_tingkatan FK
        int id_jurusan FK
        int kapasitas
        enum status
        timestamp created_at
    }
    
    tb_guru {
        int id_guru PK
        varchar nip UK
        varchar nama_guru
        varchar tempat_lahir
        date tanggal_lahir
        enum jenis_kelamin
        varchar jabatan
        enum status_kepegawaian
        varchar username UK
        varchar password
        enum status
        timestamp created_at
    }
    
    tb_siswa {
        int id_siswa PK
        varchar nisn UK
        varchar nis UK
        varchar nama_siswa
        varchar tempat_lahir
        date tanggal_lahir
        enum jenis_kelamin
        varchar alamat
        int id_kelas FK
        int id_tahun_akademik FK
        varchar password
        enum status
        timestamp created_at
    }
    
    tb_wali_kelas {
        int id_wali_kelas PK
        int id_guru FK
        int id_kelas FK
        int id_tahun_akademik FK
        enum status
        timestamp created_at
    }
    
    tb_guru_mapel {
        int id_guru_mapel PK
        int id_guru FK
        int id_mapel FK
        int id_tahun_akademik FK
        timestamp created_at
    }
    
    tb_jadwal {
        int id_jadwal PK
        int id_guru FK
        int id_mapel FK
        int id_kelas FK
        enum hari
        time jam_mulai
        time jam_selesai
        enum status
        timestamp created_at
    }
    
    tb_nilai {
        int id_nilai PK
        int id_siswa FK
        int id_mapel FK
        int id_tahun_akademik FK
        enum semester
        enum kategori_nilai
        decimal nilai
        int id_guru FK
        timestamp created_at
    }

    %% Relationships
    tb_level_user ||--o{ tb_user : "has"
    tb_tingkatan ||--o{ tb_kelas : "has"
    tb_jurusan ||--o{ tb_kelas : "has"
    tb_kelas ||--o{ tb_siswa : "contains"
    tb_tahun_akademik ||--o{ tb_siswa : "enrolled_in"
    tb_guru ||--o{ tb_wali_kelas : "assigned_as"
    tb_kelas ||--o{ tb_wali_kelas : "managed_by"
    tb_tahun_akademik ||--o{ tb_wali_kelas : "during"
    tb_guru ||--o{ tb_guru_mapel : "teaches"
    tb_mata_pelajaran ||--o{ tb_guru_mapel : "taught_by"
    tb_guru ||--o{ tb_jadwal : "schedules"
    tb_mata_pelajaran ||--o{ tb_jadwal : "subject_in"
    tb_kelas ||--o{ tb_jadwal : "class_schedule"
    tb_siswa ||--o{ tb_nilai : "receives"
    tb_mata_pelajaran ||--o{ tb_nilai : "grade_for"
    tb_guru ||--o{ tb_nilai : "graded_by"
```

---

## Diagram Kelas (Class Diagram)

```mermaid
classDiagram
    class CI_Controller {
        <<abstract>>
    }
    
    class Auth {
        +index()
        +login()
        +logout()
        -_set_session()
        -_generate_remember_token()
    }
    
    class Dashboard {
        +index()
    }
    
    class Siswa {
        +index()
        +create()
        +store()
        +edit()
        +update()
        +delete()
        +detail()
    }
    
    class Guru {
        +index()
        +create()
        +store()
        +edit()
        +update()
        +delete()
    }
    
    class Laporan {
        +index()
        +siswa()
        +guru()
        +kelas()
        +cetak_siswa()
        -cetak_siswa_pdf()
        -cetak_siswa_excel()
    }
    
    class CI_Model {
        <<abstract>>
        +__construct()
        +__get()
    }
    
    class Auth_model {
        +login_user()
        +login_guru()
        +login_siswa()
        +save_remember_token()
        +change_password()
    }
    
    class Siswa_model {
        -table: string
        -primary_key: string
        +get_all()
        +get_all_with_details()
        +get_by_id()
        +get_by_nisn()
        +insert()
        +update()
        +delete()
        +count_active()
        +count_by_gender()
        +search()
        +authenticate()
    }
    
    class Guru_model {
        -table: string
        -primary_key: string
        +get_all()
        +get_by_id()
        +get_by_nip()
        +insert()
        +update()
        +delete()
        +count_active()
        +search()
        +authenticate()
    }
    
    class Dashboard_model {
        +get_admin_stats()
        +get_walikelas_stats()
        +get_guru_stats()
        +get_student_info()
        +get_chart_data()
    }
    
    %% Relationships
    CI_Controller <|-- Auth
    CI_Controller <|-- Dashboard
    CI_Controller <|-- Siswa
    CI_Controller <|-- Guru
    CI_Controller <|-- Laporan
    
    CI_Model <|-- Auth_model
    CI_Model <|-- Siswa_model
    CI_Model <|-- Guru_model
    CI_Model <|-- Dashboard_model
    
    Auth --> Auth_model : uses
    Dashboard --> Dashboard_model : uses
    Siswa --> Siswa_model : uses
    Guru --> Guru_model : uses
    Laporan --> Siswa_model : uses
    Laporan --> Guru_model : uses
```

---

## Arsitektur Sistem

### Struktur MVC (Model-View-Controller)

```
┌─────────────────────────────────────────────┐
│           PRESENTATION LAYER                │
├─────────────────────────────────────────────┤
│  Views (Bootstrap 5, Chart.js, DataTables) │
└─────────────────────────────────────────────┘
                    │
                    ▼
┌─────────────────────────────────────────────┐
│           BUSINESS LOGIC LAYER              │
├─────────────────────────────────────────────┤
│  Controllers (Auth, Dashboard, Siswa, dll)  │
│  - Authentication & Authorization          │
│  - Input Validation                        │
│  - Business Rules                          │
│  - Report Generation                       │
└─────────────────────────────────────────────┘
                    │
                    ▼
┌─────────────────────────────────────────────┐
│           DATA ACCESS LAYER                 │
├─────────────────────────────────────────────┤
│  Models (Auth_model, Siswa_model, dll)     │
│  - Database Operations                     │
│  - Data Validation                         │
│  - Query Optimization                      │
└─────────────────────────────────────────────┘
                    │
                    ▼
┌─────────────────────────────────────────────┐
│           DATABASE LAYER                    │
├─────────────────────────────────────────────┤
│  MySQL Database                            │
│  - 15+ Tables                              │
│  - Relational Structure                    │
│  - Indexes & Views                         │
└─────────────────────────────────────────────┘
```

## Fitur Utama Sistem

### 1. Manajemen Pengguna
- **Multi-level Authentication**: Admin, Wali Kelas, Guru, Siswa
- **Role-based Access Control**: Akses menu sesuai level pengguna
- **Session Management**: Auto-logout, remember me functionality
- **Password Management**: Ubah password, validasi keamanan

### 2. Manajemen Data Master
- **Data Mata Pelajaran**: CRUD mata pelajaran umum dan kejuruan
- **Data Tingkatan**: Kelola tingkatan kelas (X, XI, XII)
- **Data Jurusan**: Manajemen jurusan sekolah (RPL, TKJ, MM, dll)
- **Data Kelas**: Pembentukan kelas berdasarkan tingkatan dan jurusan
- **Tahun Akademik**: Pengaturan tahun ajaran dan semester

### 3. Manajemen Data Operasional
- **Data Siswa**: Registrasi, biodata lengkap, penempatan kelas
- **Data Guru**: Profil guru, mata pelajaran yang diampu
- **Wali Kelas**: Penugasan wali kelas per tahun ajaran
- **Jadwal Pelajaran**: Penjadwalan mata pelajaran
- **Input Nilai**: Sistem penilaian siswa

### 4. Sistem Laporan
- **Laporan Siswa**: Filter berdasarkan kelas, jurusan
- **Laporan Guru**: Data guru dan mata pelajaran
- **Laporan Kelas**: Informasi kelas dan wali kelas
- **Export Data**: Format PDF dan Excel
- **Statistik Dashboard**: Visualisasi data dengan Chart.js

### 5. Dashboard Multi-Level
- **Dashboard Admin**: Statistik lengkap, manajemen sistem
- **Dashboard Wali Kelas**: Data kelas yang diampu
- **Dashboard Guru**: Jadwal mengajar, mata pelajaran
- **Dashboard Siswa**: Jadwal pelajaran, nilai, biodata

---

## Instalasi dan Konfigurasi

### Requirements
- PHP 7.2 atau lebih tinggi
- MySQL 5.7 atau lebih tinggi
- Apache Web Server
- XAMPP (Recommended)

### Langkah Instalasi
1. Clone repository ke direktori `htdocs/sisfo`
2. Import database dari file `database_sisfo.sql`
3. Konfigurasi database di `application/config/database.php`
4. Akses sistem melalui `http://localhost/sisfo`
5. Login default: **admin** / **admin123**

### Struktur Database
Sistem menggunakan 15+ tabel utama dengan relasi yang terstruktur:
- **Master Tables**: tingkatan, jurusan, mata_pelajaran, tahun_akademik
- **User Tables**: user, guru, siswa, level_user
- **Operational Tables**: kelas, wali_kelas, guru_mapel, jadwal, nilai
- **System Tables**: menu, user_access, audit_log

---

*Dokumentasi ini dibuat untuk memberikan pemahaman menyeluruh tentang arsitektur dan fungsionalitas Sistem Informasi Sekolah SMK Bina Mandiri.*