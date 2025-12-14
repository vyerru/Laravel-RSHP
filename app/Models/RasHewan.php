<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // 1. Import SoftDeletes

class RasHewan extends Model
{
    use SoftDeletes; // 2. Gunakan Trait

    protected $table = 'ras_hewan';
    protected $primaryKey = 'idras_hewan';

    protected $fillable = [
        'nama_ras', 
        'idjenis_hewan', // Foreign Key
        'deleted_by'     // Kolom audit soft delete
    ];

    public $timestamps = false;
 
    // Relasi ke Jenis Hewan (Many to One)
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