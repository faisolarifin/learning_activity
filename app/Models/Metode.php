<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Metode extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'ac_metode';
    protected $primaryKey = 'id_mtd';
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    protected $fillable = ['id_thn', 'nm_metode'];

    public function tahun()
    {
        return $this->belongsTo(Tahun::class, 'id_thn', 'id_thn');
    }
 
}
