<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pet extends Model
{
    use SoftDeletes;
    protected $table = "pet";
    protected $primaryKey = "idpet";
    protected $fillable = ['nama', 'tanggal_lahir', 'warna_tanda', 'jenis_kelamin', 'deleted_by', 'idras_hewan', 'idpemilik'];
    public $timestamps = false;

    public function pemilik()
    {
        return $this->belongsTo(Pemilik::class, 'idpemilik', 'idpemilik');
    }
    
    public function rasHewan()
    {
        return $this->belongsTo(RasHewan::class, 'idras_hewan', 'idras_hewan');
    }

    protected static function booted()
    {
        static::deleted(function ($pet) {
            // Hapus semua jadwal temu dokter untuk hewan ini
            $pet->temuDokter()->each(function($jadwal) {
                $jadwal->delete();
            });
        });

        static::restored(function ($pet) {
            $pet->temuDokter()->withTrashed()->restore();
        });
    }
}