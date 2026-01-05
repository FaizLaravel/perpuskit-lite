<?php

namespace App\Console\Commands;

use App\Models\Loan;
use Illuminate\Console\Command;
use App\Models\Peminjaman;
use App\Models\PeminjamanBuku;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

use function Illuminate\Log\log;
use function Symfony\Component\Clock\now;

class UpdateStatusTerlambat extends Command
{

    protected $signature = 'peminjaman:update-terlambat';
    protected $description = 'Update status peminjaman yang melewati jatuh tempo';

    public function handle()
    {


        // Ambil waktu hari ini tanpa jam
        $hariIni = Carbon::now();
        // Ambil peminjaman yang sudah lewat jatuh tempo & masih dipinjam
        $peminjamanTerlambat = Loan::where('tanggal_jatuh_tempo', '<', $hariIni)->where('status', 'dipinjam')
            ->get();

        // Log::info('Jumlah data terlambat', [
        //     'count' => $peminjamanTerlambat->count(),
        //     'hariIni' => $hariIni->startOfDay()->toDateTimeString(),
        // ]);
        foreach ($peminjamanTerlambat as $item) {

            // Normalisasi jatuh tempo ke 00:00
            $jatuhTempo = Carbon::parse($item->tanggal_jatuh_tempo)->startOfDay();

            // Hitung jumlah hari terlambat
            $hariTerlambat = $jatuhTempo->diffInDays($hariIni->startOfDay());

            // Hitung denda (Rp1.000 / hari)
            $denda = $hariTerlambat * 1000;

            if ($item->denda != $denda) {
                $item->update([
                    'status' => 'terlambat',
                    'denda'  => $denda,
                ]);
            }

            // Update status & denda
            // $item->update([
            //     'status' => 'terlambat',
            //     'denda'  => $denda,
            // ]);

            // Optional: log untuk debugging
            Log::info("Update peminjaman ID {$item->id}: hariTerlambat={$hariTerlambat}, denda={$denda}");
        }

        $this->info('Status peminjaman terlambat berhasil diperbarui.');
    }
}
