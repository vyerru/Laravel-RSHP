<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pemilik extends Model
{
    use SoftDeletes;

    protected $table = 'pemilik';
    protected $primaryKey = 'idpemilik';
    
    public $timestamps = false;

    protected $fillable = [
        'iduser',    // Foreign Key ke tabel User
        'no_wa',
        'alamat',
        'deleted_by'
    ];

    // Relasi ke User (Pemilik milik satu User)
    public function user()
    {
        return $this->belongsTo(User::class, 'iduser', 'iduser');
    }
}