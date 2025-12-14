<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pet extends Model
{
    use SoftDeletes;

    protected $table = 'pet';
    protected $primaryKey = 'idpet';
    protected $fillable = ['nama', 'tanggal_lahir', 'warna_tanda', 'jenis_kelamin', 'idpemilik', 'idras_hewan', 'deleted_by'];

    public $timestamps = false;

    public function pemilik() { return $this->belongsTo(Pemilik::class, 'idpemilik', 'idpemilik'); }
    public function rasHewan() { return $this->belongsTo(RasHewan::class, 'idras_hewan', 'idras_hewan'); }
    
    // Relasi ke Temu Dokter
    public function temuDokter()
    {
        return $this->hasMany(TemuDokter::class, 'idpet', 'idpet');
    }

    /**
     * Relasi HasManyThrough
     * Mengambil data Rekam Medis melalui tabel perantara (TemuDokter)
     */
    public function rekamMedis()
    {
        return $this->hasManyThrough(
            RekamMedis::class,      // Model Tujuan (Akhir)
            TemuDokter::class,      // Model Perantara
            'idpet',                // FK di tabel perantara (temu_dokter.idpet)
            'idreservasi_dokter',   // FK di tabel tujuan (rekam_medis.idreservasi_dokter)
            'idpet',                // Local Key di tabel asal (pet.idpet)
            'idreservasi_dokter'    // Local Key di tabel perantara (temu_dokter.idreservasi_dokter)
        );
    }
}