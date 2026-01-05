<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'judul' => $this->judul,
            'penulis' => $this->penulis,
            'penerbit' => $this->penerbit,
            'tanggal_terbit' => $this->tanggal_terbit,
            'category_id' => $this->category_id,
            'isbn' => $this->isbn,
            'jumlah_halaman' => $this->jumlah_halaman,
            'deskripsi' => $this->deskripsi,

            'category' => new CategoryResource(
                $this->whenLoaded('category')
            ),
        ];
    }
}
