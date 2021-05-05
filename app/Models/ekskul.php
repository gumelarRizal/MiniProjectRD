<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ekskul extends Model
{
    use HasFactory;
    protected $table = "ekskul";

    public function pendaftaran()
    {
        return $this->hasMany('App\Models\pendaftaran_ekskul');
    }
}
