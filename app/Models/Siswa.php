<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;
    protected $table = "siswa";
    protected $fillable = 
    [
        'id',
        'nis',
        'nama',
        'kelas',
        'alamat',
        'tempat_lahir',
        'jenis_kelamin',
        'tanggal_lahir',
        'no_telp',
        'foto',
    ];
}
