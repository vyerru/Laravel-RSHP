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
}