<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tahun extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'ac_tahun';
    protected $primaryKey = 'id_thn';
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    protected $fillable = ['nm_tahun', 'deskripsi'];
}
