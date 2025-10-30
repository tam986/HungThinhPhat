<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    protected $table = 'otps';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'user_id', 'email', 'otp_code', 'expires_at'];
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}