<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KategoriKlinis extends Model
{
    use SoftDeletes;
    protected $table = 'kategori_klinis';
    protected $primaryKey = 'idkategori_klinis';
    protected $fillable = ['nama_kategori_klinis', 'deleted_by'];
    public $timestamps = false;

    public function KodeTindakanTerapi() {
        return $this->hasMany(
            KodeTindakanTerapi::class, 'idkategori_klinis', 'idkategori_klinis');
    }


}