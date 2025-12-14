<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perawat extends Model
{
    protected $table = 'perawat';
    protected $primaryKey = 'id_perawat';
    
    // --- TAMBAHKAN/UPDATE BAGIAN INI ---
    protected $fillable = [
        'id_user', 
        'alamat', 
        'no_hp', 
        'pendidikan',
        'jenis_kelamin'
    ];

    public $timestamps = false;
    // -----------------------------------

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'iduser');
    }
}