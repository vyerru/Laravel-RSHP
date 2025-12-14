<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kategori extends Model
{
    use SoftDeletes;
    protected $table = 'kategori';
    protected $primaryKey = 'idkategori';
    protected $fillable = ['nama_kategori', 'deleted_by'];
    public $timestamps = false;

    public function kodeTindakanTerapi() {
        return $this->hasMany(
            KodeTindakanTerapi::class, 'idkategori', 'idkategori');
    }

    protected static function booted()
    {
        static::deleted(function ($kategori) {
            $kategori->kodeTindakan()->each(function($kode) {
                $kode->delete();
            });
        });

        static::restored(function ($kategori) {
            $kategori->kodeTindakan()->withTrashed()->restore();
        });
    }
}