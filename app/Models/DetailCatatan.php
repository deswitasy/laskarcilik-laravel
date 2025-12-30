<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailCatatan extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'detail_catatan';
    
    // Primary key
    protected $primaryKey = 'id_detail';
    
    // Kolom yang boleh diisi (mass assignment)
    protected $fillable = [
        'id_catatan',
        'id_kategori',
        'deskripsi'
    ];

    // Relationship: DetailCatatan belongsTo CatatanPerkembangan (1 detail milik 1 catatan)
    public function catatanPerkembangan()
    {
        return $this->belongsTo(CatatanPerkembangan::class, 'id_catatan', 'id_catatan');
    }
    
    // Relationship: DetailCatatan belongsTo Kategori (1 detail untuk 1 aspek/kategori)
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }
}