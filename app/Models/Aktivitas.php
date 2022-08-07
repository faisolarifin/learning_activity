<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aktivitas extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'ac_aktifitas';
    protected $primaryKey = 'id_akt';
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    protected $fillable = [
        'id_mtd',
        'id_thn',
        'id_bln',
        'acara',
        'tgl_awal',
        'tgl_akhir',
        'status',
    ];

    public function metode()
    {
        return $this->belongsTo(Metode::class, 'id_mtd', 'id_mtd');
    }
    public function bulan()
    {
        return $this->belongsTo(Bulan::class, 'id_bln', 'id_bln');
    }
    public function tahun()
    {
        return $this->belongsTo(Tahun::class, 'id_thn', 'id_thn');
    }
}
