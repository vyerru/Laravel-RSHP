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

    public function temuDokter()
    {
        return $this->hasMany(TemuDokter::class, 'idpet', 'idpet');
    }
    public function rekamMedis()
    {
        return $this->hasManyThrough(
            RekamMedis::class,      
            TemuDokter::class,      
            'idpet',
            'idreservasi_dokter',   
            'idpet',                
            'idreservasi_dokter'    
        );
    }
}