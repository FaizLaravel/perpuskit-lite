<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Fortify\TwoFactorAuthenticatable;


class Loan extends Model
{
    use HasFactory;
    protected $table = 'loans';
    protected $fillable = [
        'user_id',
        'book_id',
        'kode_transaksi',
        'tanggal_pengajuan',
        'tanggal_peminjaman',
        'tanggal_jatuh_tempo',
        'tanggal_pengembalian',
        'status',
        'status_perpanjangan',
        'status_pembayaran',
        'denda',
        'catatan',
    ];

    public function scopePaymentQueue($query)
    {
        return $query->whereIn('status', ['terlambat', 'bayar']);
    }
    public function scopeExtensionRequestQueue($query)
    {
        return $query->where('status_perpanjangan', 'pending')->where('status', 'dipinjam');
    }
    public function scopeActiveLoans($query)
    {
        return $query->whereHas('book', function ($q) {
            $q->where('status', 'pending');
        });
    }
    public function scopeLoanRequest($query)
    {
        return $query->where('status', 'pending');
    }
    public function scopeMyRequest($query)
    {
        return $query->where('user_id', auth()->id())
            ->whereIn('status', ['pending', 'dibatalkan']);
    }
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId)->where('status', 'dipinjam');
    }
    public function scopeLoanHistory($query)
    {
        return $query->where('user_id', auth()->id())
            ->whereNotIn('status', ['pending', 'dipinjam']);
    }
    public function scopeSearch($query, $search, $column = null)
    {
        if (!$search) return $query;

        return $query->where(function ($q) use ($search, $column) {
            match ($column) {
                'kode_transaksi' =>
                $q->where('kode_transaksi', 'like', "%{$search}%"),

                'user_id' =>
                $q->whereHas(
                    'user', // loan request (user)
                    fn($u) =>
                    $u->where('name', 'like', "%{$search}%")
                ),

                'book_id' =>
                $q->whereHas(
                    'book', // loan request (book)
                    fn($b) =>
                    $b->where('judul', 'like', "%{$search}%")
                ),

                'judul' =>
                $q->whereHas(
                    'book', // loan request (book)
                    fn($b) =>
                    $b->where('judul', 'like', "%{$search}%")
                ),

                'penulis' =>
                $q->whereHas(
                    'book', // loan request (book)
                    fn($b) =>
                    $b->where('penulis', 'like', "%{$search}%")
                ),

                'penerbit' =>
                $q->whereHas(
                    'book', // loan request (book)
                    fn($b) =>
                    $b->where('penerbit', 'like', "%{$search}%")
                ),

                'jatuh_tempo' =>
                $q->whereRaw(
                    "DATEDIFF(loans.tanggal_jatuh_tempo, loans.tanggal_peminjaman) = ?",
                    [(int) $search]
                ),

                default =>
                $q->whereRaw(
                    "DATEDIFF(loans.tanggal_jatuh_tempo, loans.tanggal_peminjaman) = ?",
                    [(int) $search]
                )->orWhere('kode_transaksi', 'like', "%{$search}%")
                    ->orWhereHas('user', fn($u) =>
                    $u->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('book', fn($b) =>
                    $b->where('judul', 'like', "%{$search}%")->orWhere('penulis', 'like', "%{$search}%")->orWhere('penerbit', 'like', "%{$search}%"))
                    ->orWhere('status', 'like', "{$search}"),
                // 'jatuh_tempo' => $query
                //     ->orderByRaw(
                //         "DATEDIFF(loans.tanggal_jatuh_tempo, loans.tanggal_peminjaman) $order"
                //     ),
            };
        });
    }
    public function scopeSort(
        Builder $query,
        ?string $sortColumn,
        ?string $order
    ): Builder {

        if (!$sortColumn || !$order) {
            return $query; // ⛔ jangan latest()
        }

        return match ($sortColumn) {

            'user_id' => $query
                ->join('users', 'loans.user_id', '=', 'users.id')
                ->orderBy('users.name', $order)
                ->select('loans.*'),

            'book_id' => $query
                ->join('books', 'loans.book_id', '=', 'books.id')
                ->orderBy('books.judul', $order)
                ->select('loans.*'),

            'judul' => $query
                ->join('books', 'loans.book_id', '=', 'books.id')
                ->orderBy('books.judul', $order)
                ->select('loans.*'),

            'penulis' => $query
                ->join('books', 'loans.book_id', '=', 'books.id')
                ->orderBy('books.penulis', $order)
                ->select('loans.*'),

            'penerbit' => $query
                ->join('books', 'loans.book_id', '=', 'books.id')
                ->orderBy('books.penerbit', $order)
                ->select('loans.*'),

            'jatuh_tempo' => $query
                ->orderByRaw(
                    "DATEDIFF(loans.tanggal_jatuh_tempo, loans.tanggal_peminjaman) $order"
                ),

            // 'jatuh_tempo' => $query
            //     ->addSelect(DB::raw(
            //         'DATEDIFF(loans.tanggal_jatuh_tempo, loans.tanggal_peminjaman) AS jatuh_tempo'
            //     ))
            //     ->orderBy('jatuh_tempo', $order),

            'kode_transaksi', 'status' =>
            $query->orderBy($sortColumn, $order),

            default => $query,
        };
    }

    public function scopeFilterStatus($query, $status)
    {
        if ($status) {
            $query->where('status', $status);
        }

        return $query;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
