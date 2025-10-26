<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KodeTindakanTerapi extends Model
{
    protected $table = 'kode_tindakan_terapi';
    protected $primaryKey = 'idkkode_tindakan_terapi';
    protected $fillable = ['kode', 'deskripsi_tindakan_terapi'];
    public $timestamps = false;


    public function kategori() {
        return $this->belongsTo(
            Kategori::class, 'idkategori', 'idkategori');
    }

    public function kategoriKlinis() {
        return $this ->belongsTo(
            KategoriKlinis::class, 'idkategori_klinis', 'idkategori_klinis');
        }
}