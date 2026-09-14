<?php

namespace App\Http\Resources;

use Illuminate\Http\Request; 
use Illuminate\Http\Resources\Json\JsonResource;


class AlatResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'kategori_id' => $this->kategori_id,
            'nama_alat' => $this->nama_alat,
            'stok' => $this->stok,
            'status_kondisi' => $this->status_kondisi,
            'deskripsi' => $this->deskripsi,
            'kategori' => $this->whenLoaded('kategori'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}