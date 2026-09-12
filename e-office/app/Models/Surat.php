<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    protected $fillable = [
        'pengirim_id',
        'penerima_id',
        'perihal',
        'isi',
        'file',
        'is_read',
        'surat_dari',
        'tanggal_surat',
        'no_agenda',
        'sifat',
    ];

    public function pengirim()
    {
        return $this->belongsTo(User::class, 'pengirim_id');
    }

    public function penerima()
    {
        return $this->belongsTo(User::class, 'penerima_id');
    }
}
