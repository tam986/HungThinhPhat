<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nhacungcap extends Model
{
    protected $table = 'nhacungcaps';
    protected $fillable = ['tennhacungcap', 'img', 'anhien', 'thutu'];

    public function sanphams()
    {
        return $this->hasMany(Sanpham::class, 'id_nhacungcap', 'id');
    }
}