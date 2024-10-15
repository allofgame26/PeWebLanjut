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
}
