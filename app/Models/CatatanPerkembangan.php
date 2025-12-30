<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatatanPerkembangan extends Model
{
    use HasFactory;

    protected $table = 'catatan_perkembangan';

    protected $primaryKey = 'id_catatan';

    protected $fillable = [
        'id_user',
        'id_siswa',
        'tanggal_catat',
        'semester',
        'tahun_ajaran'
    ];

    protected $casts = [
        'tanggal_catat' => 'date',
        'semester' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id_siswa');
    }

    public function detailCatatan()
    {
        return $this->hasMany(DetailCatatan::class, 'id_catatan', 'id_catatan');
    }

    public function foto()
    {
        return $this->hasMany(Foto::class, 'id_catatan', 'id_catatan');
    }
}