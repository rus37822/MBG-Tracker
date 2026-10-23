<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MbgRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'kelas',
        'jumlah',
        'waktu_pengambilan',
        'catatan',
        'foto',
    ];

    protected $casts = [
        'jumlah' => 'integer',
        'waktu_pengambilan' => 'datetime',
    ];
}
