<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

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
        'deleted_by'
    ];
    public $timestamps = false;

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

    protected static function booted() {
        static::deleted(function ($user) {
            // 1. Hapus data RoleUser (status hak akses)
            $user->roleUser()->each(function($roleUser) {
                $roleUser->delete();
            });

            // 2. Hapus data Pemilik (jika ada)
            if ($user->pemilik) {
                $user->pemilik->delete();
            }

            // 3. Hapus data Dokter (jika ada)
            if ($user->dokter) {
                $user->dokter->delete();
            }

            // 4. Hapus data Perawat (jika ada)
            if ($user->perawat) {
                $user->perawat->delete();
            }
        });

        static::restored(function ($user) {
            $user->roleUser()->withTrashed()->restore();
            if ($user->pemilik()->withTrashed()->first()) $user->pemilik()->withTrashed()->restore();
            if ($user->dokter()->withTrashed()->first()) $user->dokter()->withTrashed()->restore();
        });
    }

    protected function role(): Attribute
    {
        return Attribute::make(
            get: function () {
                // 1. Mengambil model pivot (RoleUser)
                $roleUserPivot = $this->roleUser->first(); 
                
                // 2. Jika user tidak punya role
                if (!$roleUserPivot) {
                    return null;
                }

                // 3. Mengambil model Role DARI pivot
                //    (Ini memanggil relasi 'role()' di RoleUser.php)
                $roleModel = $roleUserPivot->role; 
                
                if (!$roleModel) {
                    return null; 
                }

                // 4. Ambil nama role dari model Role
                //    (Kolom di tabel 'role' Anda adalah 'role')
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

    public function perawat() {
        return $this->hasOne(
            Perawat::class, 'iduser', 'iduser');
    }

    public function dokter() {
        return $this->hasOne(
            Dokter::class, 'iduser', 'iduser');
    }
}