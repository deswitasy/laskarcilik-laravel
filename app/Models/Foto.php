<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Foto extends Model
{
    protected $table = 'foto';
    protected $primaryKey = 'id_foto';
    
    protected $fillable = ['id_catatan', 'file_path', 'keterangan'];
    
    public function catatanPerkembangan()
    {
        return $this->belongsTo(CatatanPerkembangan::class, 'id_catatan', 'id_catatan');
    }
}
