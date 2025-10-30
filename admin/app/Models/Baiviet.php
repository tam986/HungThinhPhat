<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Baiviet extends Model

{
    use HasFactory, SoftDeletes;
    protected $table = 'baiviets';
    protected $primaryKey = 'id';
    protected $fillable = [
        'tieude',
        'noidung',
        'anhdaidien',
        'motangan',
        'seotieude',
        'slug',
        'id_danhmuc',
        'anhien',
        'id_user'
    ];
    public $timestamps = true;
    public function danhmucbaiviet(): BelongsTo
    {
        return $this->belongsTo(DanhMucBaiViet::class, 'id_danhmuc', 'id');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
