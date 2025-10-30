<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nhanbanh extends Model
{
    protected $table = 'nhanbanhs';
    protected $primaryKey = 'id';
    protected $fillable = ['tenNhanBanh'];
    public $timestamps = false;
     public function bienthe()
    {
        return $this->hasMany(BienThe::class, 'id_nhanbanh','id');
    }
}
