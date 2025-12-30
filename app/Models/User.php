<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id_user';
    
    protected $fillable = [
        'nama_user', 
        'username', 
        'email', 
        'password', 
        'no_hp', 
        'hak_akses', 
        'status'
    ];
    
    protected $hidden = [
        'password', 
        'remember_token'
    ];
    
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    // Override method untuk custom primary key
    public function getAuthIdentifierName()
    {
        return 'id_user';
    }
    
    public function catatanPerkembangan()
    {
        return $this->hasMany(CatatanPerkembangan::class, 'id_user', 'id_user');
    }
}
