<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailJurnal extends Model
{
    use HasFactory;

    protected $table = 'detail_jurnal';
    protected $fillable = ['no_jurnal', 'no_akun', 'kredit', 'debit'];
    protected $primaryKey = 'id';

    public function jurnal()
    {
        return $this->belongsTo(Jurnal::class, 'no_jurnal', 'no_jurnal');
    }

    public function akun()
    {
        return $this->belongsTo(Akun::class, 'no_akun', 'no_akun');
    }
}
