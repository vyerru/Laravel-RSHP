<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RekamMedis extends Model
{
    use SoftDeletes;

    protected $table = 'rekam_medis';
    protected $primaryKey = 'idrekam_medis';

    protected $fillable = [
        'idreservasi_dokter', // Kunjungan mana yang diperiksa?
        'dokter_pemeriksa',   // Siapa dokternya? (ID RoleUser)
        'anamnesa',           // Keluhan awal
        'temuan_klinis',      // Hasil periksa
        'diagnosa',           // Kesimpulan penyakit
        'deleted_by'
    ];

    // Relasi ke Reservasi
    public function reservasi()
    {
        return $this->belongsTo(TemuDokter::class, 'idreservasi_dokter', 'idreservasi_dokter');
    }

    // Relasi ke Dokter (Pemeriksa)
    public function dokter()
    {
        return $this->belongsTo(RoleUser::class, 'dokter_pemeriksa', 'idrole_user');
    }

    // Relasi ke Detail Tindakan (One to Many)
    public function detailTindakan()
    {
        return $this->hasMany(DetailRekamMedis::class, 'idrekam_medis', 'idrekam_medis');
    }
}