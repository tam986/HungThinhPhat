<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nhanbanh extends Model
{
    protected $table = 'nhanbanhs';
    protected $fillable = ['tenNhanBanh'];

    public function bienthes()
    {
        return $this->hasMany(Bienthe::class, 'id_nhanbanh', 'id');
    }
}
