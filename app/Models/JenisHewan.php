<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JenisHewan extends Model
{
    use SoftDeletes;
    protected $table = 'jenis_hewan';
    protected $primaryKey = 'idjenis_hewan';
    protected $fillable = ['nama_jenis_hewan', 'deleted_by'];
    public $timestamps = false;

    public function rasHewan()
    {
        return $this->hasMany(RasHewan::class, 'idjenis_hewan', 'idjenis_hewan');
    }


    // Boot method untuk mengatur cascade delete dan restore
    protected static function booted()
    {
        static::deleted(function ($jenis) {
            $jenis->rasHewan()->each(function($ras) {
                $ras->delete();
            });
        });

        static::restored(function ($jenis) {
            $jenis->rasHewan()->withTrashed()->restore();
        });
    }
}
