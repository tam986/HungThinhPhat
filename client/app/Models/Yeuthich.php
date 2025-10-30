<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Yeuthich extends Model
{
    protected $table = 'yeu_thich';
    protected $primaryKey = 'id';
    protected $fillable = ['id_bienthe', 'id_user', 'thutu'];
    public $timestamps = true;
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
    public function bienthe()
    {
        return $this->belongsTo(Bienthe::class, 'id_bienthe', 'id');
    }
}
