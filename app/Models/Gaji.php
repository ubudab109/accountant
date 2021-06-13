<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gaji extends Model
{
    use HasFactory;

    protected $table = 'gaji';
    protected $fillable = ['kode_gaji', 'tanggal', 'kode_pegawai', 'gaji_pokok', 'potongan', 'bonus', 'total_gaji'];
    protected $primaryKey = 'id';

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'kode_pegawai', 'id_pegawai');
    }

    public function jurnal()
    {
        return $this->hasOne(Jurnal::class, 'kode_gaji', 'kode_gaji');
    }
}
