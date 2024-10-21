<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriModel extends Model
{
    public function barang(): HasMany { // One to Many Relationship
        return $this->hasMany(BarangModel::class, 'barang_id', 'barang_id');        
    }
    use HasFactory;

    protected $table = 'm_kategori'; //Mendefinisikan nama tabel yang digunakan oleh model ini
    protected $primaryKey = 'kategori_id'; //mendefinisikan primary key dari tabel yang digunakan

    
    protected $fillable = ['kategori_kode','kategori_nama'];
}
