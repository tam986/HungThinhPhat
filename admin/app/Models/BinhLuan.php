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
        return $this->belongsTo(User::class);
    }

    public function bienthe()
    {
        return $this->belongsTo(BienThe::class, 'id_bienthe');
    }
}
