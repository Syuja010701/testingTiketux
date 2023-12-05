<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriCoa extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function chartOfAccount(){
        return $this->hasMany(ChartOfAccount::class);
    }
}
