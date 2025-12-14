<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TemuDokter extends Model
{
    use SoftDeletes;

    protected $table = 'temu_dokter';
    protected $primaryKey = 'idreservasi_dokter';

    protected $fillable = [
        'no_urut',
        'waktu_daftar', // Format: Y-m-d H:i:s
        'status',       // 0: Menunggu, 1: Diperiksa, 2: Selesai, 9: Batal
        'idpet',
        'idrole_user',  // ID Dokter (dari tabel role_user)
        'deleted_by'
    ];
    public $timestamps = false;

    // Helper untuk Label Status
    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            '0' => 'Menunggu',
            '1' => 'Diperiksa',
            '2' => 'Selesai',
            '9' => 'Batal',
            default => 'Unknown',
        };
    }

    public function getStatusBadgeAttribute()
    {
        return match ($this->status) {
            '0' => 'warning', // Kuning
            '1' => 'info',    // Biru
            '2' => 'success', // Hijau
            '9' => 'danger',  // Merah
            default => 'secondary',
        };
    }

    // Relasi ke Pet
    public function pet()
    {
        return $this->belongsTo(Pet::class, 'idpet', 'idpet');
    }

    // Relasi ke Dokter (RoleUser)
    public function dokter()
    {
        return $this->belongsTo(RoleUser::class, 'idrole_user', 'idrole_user');
    }

    public function rekamMedis()
    {
        return $this->hasOne(RekamMedis::class, 'idreservasi_dokter', 'idreservasi_dokter');
    }
}