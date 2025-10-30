<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Khoiluong extends Model
{
    use HasFactory;
    protected $table = 'khoiluongs';
    protected $primaryKey = 'id';
    protected $fillable = ['khoiluong'];
    public $timestamps = false;
     public function bienthe()
    {
        return $this->hasMany(BienThe::class, 'id_khoiluong', 'id');
    }
}