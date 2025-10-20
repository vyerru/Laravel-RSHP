<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemilik extends Model
{
    protected $table = "pemilik";
    protected $fillable = ['no_wa', 'alamat'];
    protected $primaryKey = 'idpemilik';

    public function user()  {
        return $this->belongsTo(User::class, 'iduser', 'iduser');
    }
}
