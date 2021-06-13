<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Akun extends Model
{
    use HasFactory;

    protected $table = 'akun';
    protected $fillable = ['no_akun', 'nama_akun'];
    protected $primaryKey = 'id';

    public function detailJurnal()
    {
        return $this->hasMany(DetailJurnal::class, 'no_akun', 'no_akun');
    }
}
