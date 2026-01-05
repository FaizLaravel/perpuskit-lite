<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'book_id' => $this->book_id,
            'kode_transaksi' => $this->kode_transaksi,
            'tanggal_pengajuan' => $this->tanggal_pengajuan,
            'tanggal_peminjaman' => $this->tanggal_peminjaman,
            'tanggal_jatuh_tempo' => $this->tanggal_jatuh_tempo,
            'status' => $this->status,
            'tanggal_pengembalian' => $this->tanggal_pengembalian,
            'catatan' => $this->catatan,
            'denda' => $this->denda,

            'user' => new UserResource($this->whenLoaded('user')),
            'book' => new BookResource($this->whenLoaded('book')),
        ];
    }
}
