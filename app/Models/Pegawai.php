<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    protected $table = 'pegawai';
    protected $fillable = ['id_pegawai', 'jabatan', 'alamat', 'telepon', 'nama_pegawai', 'jumlah_cuti'];
    protected $primaryKey = 'id';

    public function gaji()
    {
        return $this->hasOne(Gaji::class, 'kode_pegawai', 'id_pegawai');
    }

    public function absensi()
    {
        return $this->hasOne(Absensi::class, 'id_pgw', 'id_pegawai');
    }
}
