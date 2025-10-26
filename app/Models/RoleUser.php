<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    protected $table = "role_user";
    protected $primaryKey = "idrole_user";
    protected $fillable = ['status'];
    public $timestamps = false;

    public function getStatusLabelAttribute(): string
    {
        return $this->status ? 'Aktif' : 'Nonaktif';
    }
    
    public function user() {
        return $this->belongsTo(User::class, 'iduser', 'iduser');
    }

    public function role() {
        return $this->belongsTo(Role::class, 'idrole', 'idrole');
    }

}
