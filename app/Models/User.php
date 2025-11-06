<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute; 

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $table = 'user';
    protected $primaryKey = 'iduser';
    protected $fillable = [
        'nama',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected function role(): Attribute
    {
        return Attribute::make(
            get: function () {
                // 1. Mengambil model perantara (pivot) yang pertama
                //    (Ini memanggil relasi 'roleUser()' Anda)
                $roleUserPivot = $this->roleUser->first(); 
                
                // 2. Jika user tidak punya role sama sekali
                if (!$roleUserPivot) {
                    return null;
                }

                // 3. [ASUMSI 1]
                //    Kita mengambil model 'Role' DARI model 'RoleUser'.
                //    Ini mengasumsikan model 'RoleUser' Anda punya relasi bernama 'role'
                $roleModel = $roleUserPivot->role; 
                
                if (!$roleModel) {
                    return null; // Ada pivot tapi tidak terhubung ke role?
                }

                // 4. [ASUMSI 2]
                //    Ambil nama role dari model 'Role'
                //    Ganti 'name' dengan nama kolom yang benar (misal: 'nama_role')
                return $roleModel->nama_role; 
            },
        );
    }

    public function pemilik() {
        return $this->hasOne(
            Pemilik::class, 'iduser', 'iduser');
    }

    public function roleUser() {
        return $this->hasMany(RoleUser::class, 'iduser', 'iduser');
    }

}