<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Khoiluong extends Model
{
    protected $table = 'khoiluongs';
    protected $fillable = ['khoiluong'];

    public function bienthes()
    {
        return $this->hasMany(Bienthe::class, 'id_khoiluong', 'id');
    }
}
