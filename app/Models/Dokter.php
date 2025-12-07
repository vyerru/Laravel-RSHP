<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    protected $table = 'dokter';
    protected $primaryKey = 'id_dokter';
    protected $fillable = [
        'alamat',
        'no_hp',
        'bidang_dokter',
        'jenis_kelamin',
    ];
    public $timestamps = false;

    public function user(){
        $this->belongsTo(User::class, 'id_user', 'iduser');
    }
}
