<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendaftaranEkskul extends Model
{
    use HasFactory;
    protected $table = "pendaftaran_ekskul";
    protected $fillable = 
    [
        'id',
        'id_siswa',
        'id_ekskul',
        'id_pembina',
        'nilai'
    ];

    public function ekskul()
    {
        return $this->belongsTo('App\Models\ekskul');
    }
}
