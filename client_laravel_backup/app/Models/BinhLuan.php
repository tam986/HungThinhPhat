<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BinhLuan extends Model
{
    protected $table = 'binhluans';
    protected $primaryKey = 'id';
    protected $fillable = ['noidung', 'id_user', 'id_bienthe', 'anhien', 'trangthai'];
    public $timestamps = true;
    public function user()
    {
        return $this->belongsTo(User::class,'id_user');
    }

    public function bienthe()
    {
        return $this->belongsTo(Bienthe::class,'id_bienthe');
    }
}
