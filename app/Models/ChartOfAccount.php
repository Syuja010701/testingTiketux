<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChartOfAccount extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];

    public function kategoriCoa(){
        return $this->belongsTo(KategoriCoa::class, 'kategori_coa_id');
    }

    public function transaksi(){
        return $this->hasMany(Transaksi::class,'coa_id');
    }
}
