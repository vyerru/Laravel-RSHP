<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // 1. Import SoftDeletes

class RasHewan extends Model
{
    use SoftDeletes; 

    protected $table = 'ras_hewan';
    protected $primaryKey = 'idras_hewan';

    protected $fillable = [
        'nama_ras', 
        'idjenis_hewan', 
        'deleted_by'     
    ];

    public $timestamps = false;
 
    public function jenisHewan()
    {
        return $this->belongsTo(JenisHewan::class, 'idjenis_hewan', 'idjenis_hewan');
    }

    protected static function booted()
    {
        static::deleted(function ($ras) {
            $ras->pet()->each(function($p) {
                $p->delete();
            });
        });

        static::restored(function ($ras) {
            $ras->pet()->withTrashed()->restore();
        });
    }
}