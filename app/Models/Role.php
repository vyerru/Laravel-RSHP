<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;
    protected $table = 'role';
    protected $primaryKey = 'idrole';
    protected $fillable = ['nama_role', 'deleted_by'];
    public $timestamps = false;

    public function roleUser() {
        return $this->hasMany(
            RoleUser::class, 'idrole', 'idrole'
        );
    }
}
