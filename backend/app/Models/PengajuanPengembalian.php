<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PengajuanPengembalian extends Model
{
    protected $table = 'pengajuan_pengembalian';

    protected $fillable = [
        'peminjaman_id',
        'user_id',
        'kondisi_kembali',
    ];

    public function peminjaman(): BelongsTo
    {
        return $this->belongsTo(Peminjaman::class, 'peminjaman_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}