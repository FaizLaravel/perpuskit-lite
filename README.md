# PerpusKit Lite — Library Management Starter Kit

**Versi Gratis untuk Preview & Demo**

**PerpusKit Lite** adalah versi gratis dari *Library Management Starter Kit* berbasis **Laravel + Vue 3 (Inertia.js)** yang dirancang untuk memberikan preview dan demo sistem perpustakaan sebelum upgrade ke versi Full.

> 💡 **Ingin fitur lengkap?** [Upgrade ke PerpusKit Full](https://your-landing-page.com) untuk mendapatkan semua fitur tanpa limitasi.

---

## 🎯 Tentang Versi Lite

Versi Lite adalah **preview gratis** yang memungkinkan Anda untuk:
- ✅ **Mencoba fitur utama** tanpa biaya
- ✅ **Melihat kualitas code** dan arsitektur
- ✅ **Test UI/UX** sebelum membeli
- ✅ **Belajar struktur** sistem perpustakaan

**Tapi dengan limitasi:**
- ⚠️ Beberapa fitur memiliki limit (max 20 buku, max 5 user, dll)
- ⚠️ Beberapa fitur hanya read-only
- ⚠️ Fitur core workflow tidak tersedia (hanya di versi Full)

---

## ✨ Fitur yang Tersedia di Lite

### ✅ **Fitur Lengkap (Tanpa Limitasi)**

* **Auth & Role Management**
  * Login/Register
  * 3 Role: Admin, Petugas, Anggota
  * Permission system

* **CRUD Kategori**
  * Create, Read, Update, Delete kategori buku
  * Tidak ada limitasi

* **Dashboard Basic**
  * Statistik angka (total buku, anggota, peminjaman)
  * Overview sistem

---

### ⚠️ **Fitur dengan Limitasi**

* **CRUD Buku**
  * ✅ Full CRUD functionality
  * ⚠️ **Limit: Max 20 buku**
  * 💡 Upgrade ke Full untuk unlimited

* **CRUD User**
  * ✅ Full CRUD functionality
  * ⚠️ **Limit: Max 5 users**
  * 💡 Upgrade ke Full untuk unlimited

* **Pengajuan Peminjaman**
  * ✅ Anggota bisa mengajukan peminjaman
  * ⚠️ **Limit: 1x pengajuan per user**
  * 💡 Upgrade ke Full untuk unlimited

---

### 👁️ **Fitur Read-Only (Lihat Saja)**

* **Status Peminjaman**
  * ✅ Bisa melihat status peminjaman
  * ❌ Tidak bisa edit/update status
  * 💡 Upgrade ke Full untuk full control

* **Riwayat Peminjaman**
  * ✅ Bisa melihat riwayat peminjaman
  * ❌ Tidak bisa export/filter advanced
  * 💡 Upgrade ke Full untuk export PDF & filter lengkap

* **Penghitungan Denda**
  * ✅ Bisa melihat penghitungan denda otomatis
  * ❌ Tidak bisa input pembayaran denda
  * 💡 Upgrade ke Full untuk kelola pembayaran

---

## 🔒 Fitur yang Tidak Tersedia di Lite

Fitur-fitur berikut **hanya tersedia di versi Full**:

* ❌ **Persetujuan Peminjaman** (Core workflow)
* ❌ **Pengembalian Buku** (Core workflow)
* ❌ **Perpanjangan Peminjaman** (Fitur premium)
* ❌ **Input Pembayaran Denda** (Revenue feature)
* ❌ **Export Laporan PDF** (Fitur premium)
* ❌ **Dashboard Advanced** (Grafik, filter, export)
* ❌ **Log Aktivitas** (Enterprise feature)

> 💰 **Upgrade sekarang** untuk mendapatkan semua fitur ini dan unlimited data!

---

## 🎯 Cocok Untuk

* 🎓 **Mahasiswa** (Belajar struktur sistem perpustakaan)
* 👨‍💻 **Developer** (Preview code quality sebelum beli)
* 🏫 **Sekolah / Yayasan** (Test sistem sebelum implementasi)
* 🔍 **Evaluator** (Assess produk sebelum purchase)

---

## 🧱 Tech Stack

* **Backend:** Laravel 12
* **Frontend:** Vue 3 + TypeScript
* **Framework:** Inertia.js
* **Styling:** Tailwind CSS
* **Database:** MySQL / PostgreSQL

---

## ⚙️ Kebutuhan Sistem

* PHP >= 8.2
* Composer
* Node.js >= 18 & NPM
* MySQL >= 8.0 / PostgreSQL >= 13

---

## 🚀 Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/your-username/perpuskit-lite.git
cd perpuskit-lite
```

### 2. Install Dependency Backend

```bash
composer install
```

### 3. Setup Environment

```bash
cp .env.example .env
php artisan key:generate
```

Sesuaikan konfigurasi database di file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=perpuskit
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Migrasi & Seeder

```bash
php artisan migrate --seed
```

### 5. Install Dependency Frontend

```bash
npm install
npm run build
```

### 6. Jalankan Server

```bash
php artisan serve
```

Akses aplikasi di: **http://127.0.0.1:8000**

---

## 🔐 Akun Default

Setelah menjalankan seeder, gunakan akun berikut untuk login:

* **Admin**
  * Email: `admin@example.com`
  * Password: `password`

* **Petugas**
  * Email: `petugas@example.com`
  * Password: `password`

* **Anggota**
  * Email: `anggota@example.com`
  * Password: `password`

> ⚠️ **Penting:** Ganti password default setelah login pertama kali!

---

## 🧭 Alur Penggunaan (Lite Version)

### Sebagai Admin:

1. ✅ Login dengan akun admin
2. ✅ Buat kategori buku (unlimited)
3. ✅ Buat buku (max 20 buku)
4. ✅ Buat user (max 5 users)
5. 👁️ Lihat status peminjaman (read-only)
6. 👁️ Lihat riwayat peminjaman (read-only)
7. 👁️ Lihat penghitungan denda (read-only)

### Sebagai Anggota:

1. ✅ Login dengan akun anggota
2. ✅ Lihat daftar buku
3. ✅ Ajukan peminjaman (1x saja)
4. 👁️ Lihat status pengajuan (read-only)
5. 👁️ Lihat riwayat peminjaman (read-only)

### Limitasi yang Akan Ditemui:

* ⚠️ Saat membuat buku ke-21 → Redirect ke halaman upgrade
* ⚠️ Saat membuat user ke-6 → Redirect ke halaman upgrade
* ⚠️ Saat mengajukan peminjaman ke-2 → Redirect ke halaman upgrade
* ⚠️ Saat mencoba akses fitur locked → Redirect ke halaman upgrade

---

## 📊 Perbandingan Lite vs Full

| Fitur | Lite | Full |
|-------|------|------|
| **CRUD Kategori** | ✅ Unlimited | ✅ Unlimited |
| **CRUD Buku** | ⚠️ Max 20 | ✅ Unlimited |
| **CRUD User** | ⚠️ Max 5 | ✅ Unlimited |
| **Pengajuan Peminjaman** | ⚠️ 1x | ✅ Unlimited |
| **Persetujuan Peminjaman** | ❌ | ✅ |
| **Pengembalian Buku** | ❌ | ✅ |
| **Perpanjangan** | ❌ | ✅ |
| **Input Pembayaran Denda** | ❌ | ✅ |
| **Export PDF** | ❌ | ✅ |
| **Dashboard Advanced** | ❌ | ✅ |
| **Log Aktivitas** | ❌ | ✅ |

---

## 💰 Upgrade ke Full Version

Ingin fitur lengkap tanpa limitasi? Upgrade ke **PerpusKit Full** sekarang!

### Fitur yang Didapat:

* ✅ **Unlimited Data** (Buku, User, Peminjaman)
* ✅ **Core Workflow** (Persetujuan, Pengembalian)
* ✅ **Fitur Premium** (Perpanjangan, Export PDF)
* ✅ **Dashboard Advanced** (Grafik, Filter, Export)
* ✅ **Enterprise Features** (Log Aktivitas)

### Harga:

* **One-time:** $79
* **Subscription:** $14/month

### Cara Upgrade:

1. Kunjungi [Landing Page](https://your-landing-page.com)
2. Pilih paket Full
3. Lakukan pembayaran
4. Dapatkan akses ke repository Full version

---

## 🛠️ Kustomisasi

Beberapa hal yang mudah dikustom di versi Lite:

* Besaran denda per hari (jika fitur denda diaktifkan)
* Role & permission
* Tampilan UI (Tailwind CSS)
* Limitasi (bisa diubah di controllers)

> 💡 **Note:** Untuk kustomisasi lebih lanjut, upgrade ke Full version.

---

## 🐛 Troubleshooting

### Error: "Limit tercapai"

Ini normal di versi Lite. Upgrade ke Full untuk unlimited data.

### Error: "Fitur tidak tersedia"

Fitur tersebut hanya tersedia di versi Full. Upgrade untuk mengakses.

### Error: Database connection

Pastikan:
- Database sudah dibuat
- Konfigurasi `.env` sudah benar
- MySQL/PostgreSQL service berjalan

---

## 📄 Lisensi

Versi Lite ini **gratis** untuk:
- ✅ Personal use
- ✅ Educational purposes
- ✅ Testing & evaluation
- ✅ Learning & development

**Tidak diperbolehkan:**
- ❌ Menjual ulang source code
- ❌ Menggunakan untuk produksi tanpa upgrade
- ❌ Menghapus credit/license

---

## 📬 Dukungan

### Untuk Versi Lite:

* 📧 Buat issue di [GitHub Issues](https://github.com/your-username/perpuskit-lite/issues)
* 💬 Diskusi di [GitHub Discussions](https://github.com/your-username/perpuskit-lite/discussions)

### Untuk Versi Full:

* 📧 Email support: support@your-domain.com
* 💬 Private support channel (untuk customer Full)

---

## 🔜 Roadmap

Fitur yang akan ditambahkan di versi mendatang:

* Export laporan PDF
* Log aktivitas (audit trail)
* Pengaturan denda fleksibel
* Multi-perpustakaan
* Notifikasi Email/SMS

> 💡 **Note:** Fitur-fitur ini akan tersedia di Full version terlebih dahulu.

---

## ⭐ Star & Share

Jika PerpusKit Lite membantu Anda, jangan lupa:

* ⭐ **Star** repository ini
* 🔄 **Share** ke teman/colleague
* 💬 **Berikan feedback** di GitHub

---

## 🙏 Credits

**PerpusKit** dibuat dari studi kasus nyata, bukan sekadar tutorial.

Dibangun dengan:
* Laravel Framework
* Vue.js
* Inertia.js
* Tailwind CSS
* Dan banyak library open source lainnya

---

## 📝 Changelog

### v1.0.0 (Lite)
* ✅ Initial release
* ✅ Fitur preview dengan limitasi
* ✅ Read-only features
* ✅ Upgrade page

---

> **PerpusKit Lite** adalah versi gratis untuk preview dan demo.
> 
> Untuk fitur lengkap tanpa limitasi, [upgrade ke PerpusKit Full](https://your-landing-page.com) sekarang!
> 
> **Happy Coding!** 🚀
