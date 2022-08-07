<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bulan extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'ac_bulan';
    protected $primaryKey = 'id_bln';
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    protected $fillable = ['nm_bulan'];

    public function aktivitas()
    {
        return $this->hasMany(Aktivitas::class, 'id_bln', 'id_bln');
    }
}
