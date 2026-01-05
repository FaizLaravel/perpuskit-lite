# Implementasi Lite Plan - Dokumentasi

**Status:** ✅ Selesai - Folder `perpuskit-lite/` sudah dikonfigurasi sebagai versi Lite

---

## ✅ Yang Sudah Diimplementasikan

### 1. **Database & Model**
- ✅ Migration: `2026_01_04_123256_add_plan_column_to_users_table.php`
  - Menambah kolom `plan` (enum: 'lite', 'full') dengan default 'lite'
- ✅ User Model: Method `isLite()` dan `isFull()`
- ✅ User Model: Kolom `plan` ditambahkan ke `$fillable`

### 2. **Middleware & Gates**
- ✅ Middleware `CheckPlan`: Redirect ke `/upgrade` jika user Lite mengakses fitur Full
- ✅ Middleware `CheckLimit`: Check limit berdasarkan resource type
- ✅ AppServiceProvider: Gate `full-feature`, `can-create-book`, `can-create-user`, `can-create-loan`

### 3. **Controllers dengan Limitasi**
- ✅ BookController: Limit 20 buku untuk Lite plan
- ✅ UserController: Limit 5 user untuk Lite plan
- ✅ BookLoanController: Limit 1x pengajuan untuk Lite plan

### 4. **Routes**
- ✅ Locked features diproteksi dengan middleware `can:full-feature`:
  - `permintaans` (Perpanjangan)
  - `pengembalians` (Pengembalian)
  - `pembayarans` (Pembayaran Denda)
  - `pengajuanpeminjamans` (Persetujuan Peminjaman)
- ✅ Route `/upgrade` untuk halaman upgrade

### 5. **UI Components**
- ✅ Halaman `Upgrade.vue`: Halaman upgrade dengan perbandingan fitur
- ✅ Component `BadgePlan.vue`: Badge untuk preview/limited/locked/readonly

---

## 📋 Fitur yang Sudah Dikonfigurasi

### ✅ Preview Features (Boleh Dicoba di Lite)
- Auth & Role Management (Full)
- CRUD Kategori (Full)
- CRUD Buku (Limited: max 20)
- CRUD User (Limited: max 5)
- Dashboard Basic (Full)
- Pengajuan Peminjaman (Limited: 1x)
- Status Peminjaman (Read-only)
- Riwayat Peminjaman (Read-only)
- Lihat Denda (Read-only)

### 🔒 Locked Features (Hanya untuk Full)
- Persetujuan Peminjaman
- Pengembalian Buku
- Perpanjangan Peminjaman
- Input Pembayaran Denda
- Export Laporan PDF (belum diimplement, perlu ditambahkan)
- Dashboard Advanced (belum diimplement, perlu ditambahkan)

---

## 🚀 Langkah Selanjutnya

### 1. **Jalankan Migration**
```bash
cd perpuskit-lite
php artisan migrate
```

### 2. **Set Default Plan untuk Existing Users**
```bash
php artisan tinker
>>> App\Models\User::query()->update(['plan' => 'lite']);
```

### 3. **Update UI dengan Badge**
- Update `AppSidebar.vue` untuk menampilkan badge `BadgePlan`
- Update halaman-halaman yang perlu menampilkan badge (Book Index, User Index, dll)

### 4. **Implement Read-only Features**
- Update `LoanStatusController`: Hide edit/delete buttons jika Lite
- Update `LoanHistoryController`: Hide export buttons jika Lite
- Update halaman denda: Hide input pembayaran jika Lite

### 5. **Testing**
- Test limitasi: Coba create buku/user/loan melebihi limit
- Test locked features: Coba akses route yang locked
- Test upgrade flow: Pastikan redirect ke `/upgrade` bekerja

---

## 🔧 Cara Menggunakan

### Set User ke Full Plan (untuk testing)
```php
// Di tinker atau seeder
$user = User::find(1);
$user->plan = 'full';
$user->save();
```

### Check Plan di Controller
```php
if (auth()->user()->isLite()) {
    // Logic untuk Lite plan
}

if (auth()->user()->isFull()) {
    // Logic untuk Full plan
}
```

### Check Limit dengan Gate
```php
if (Gate::allows('can-create-book')) {
    // Boleh create book
}
```

### Protect Route dengan Middleware
```php
Route::middleware(['can:full-feature'])->group(function () {
    // Routes yang hanya untuk Full plan
});
```

---

## 📝 File yang Telah Dimodifikasi

1. `database/migrations/2026_01_04_123256_add_plan_column_to_users_table.php` (Baru)
2. `app/Models/User.php` (Updated)
3. `app/Http/Middleware/CheckPlan.php` (Baru)
4. `app/Http/Middleware/CheckLimit.php` (Baru)
5. `app/Providers/AppServiceProvider.php` (Updated)
6. `app/Http/Controllers/Admin/BookController.php` (Updated)
7. `app/Http/Controllers/Admin/UserController.php` (Updated)
8. `app/Http/Controllers/Anggota/BookLoanController.php` (Updated)
9. `routes/web.php` (Updated)
10. `resources/js/pages/Upgrade.vue` (Baru)
11. `resources/js/components/BadgePlan.vue` (Baru)

---

## ⚠️ Catatan Penting

1. **Default Plan:** Semua user baru akan otomatis memiliki plan 'lite'
2. **Existing Users:** Perlu di-update manual ke 'lite' setelah migration
3. **Upgrade Flow:** Saat ini hanya redirect ke halaman upgrade, perlu integrasi dengan payment gateway
4. **Read-only Features:** Perlu diimplement di UI untuk hide action buttons
5. **Export PDF & Dashboard Advanced:** Belum diimplement, perlu ditambahkan

---

## ✅ Checklist Final

- [x] Migration untuk kolom plan
- [x] User model dengan method isLite/isFull
- [x] Middleware CheckPlan & CheckLimit
- [x] Gates di AppServiceProvider
- [x] Limitasi di controllers
- [x] Routes dengan middleware
- [x] Halaman Upgrade
- [x] Component BadgePlan
- [ ] Update UI dengan badge (AppSidebar, dll)
- [ ] Implement read-only di UI
- [ ] Testing semua fitur
- [ ] Integrasi payment gateway (opsional)

---

**Status:** ✅ Core implementation selesai. Folder `perpuskit-lite/` siap digunakan sebagai versi Lite!


