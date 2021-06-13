<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurnal extends Model
{
    use HasFactory;

    protected $table = 'jurnal';
    protected $fillable = ['no_jurnal', 'tanggal', 'kode_gaji', 'keterangan'];
    protected $primaryKey = 'id';

    public function gaji()
    {
        return $this->belongsTo(Gaji::class, 'kode_gaji', 'kode_gaji');
    }

    public function detailJurnal()
    {
        return $this->hasMany(DetailJurnal::class, 'no_jurnal', 'no_jurnal');
    }
}
