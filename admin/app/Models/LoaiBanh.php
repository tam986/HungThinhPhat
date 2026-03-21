<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoaiBanh extends Model
{
    protected $table = 'loaibanhs';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'tenLoaiBanh'
    ];

    public function bienthe()
    {
        return $this->hasMany(BienThe::class, 'id_loaibanh', 'id');
    }
}
