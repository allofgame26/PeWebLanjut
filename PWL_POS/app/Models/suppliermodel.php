<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class suppliermodel extends Model
{
    use HasFactory;

    protected $table = 'm_supplier'; //Mendefinisikan nama tabel yang digunakan oleh model ini
    protected $primaryKey = 'supplier_id'; //mendefinisikan primary key dari tabel yang digunakan

    
    protected $fillable = ['supplier_kode','supplier_nama','supplier_alamat'];

    public function stok(): HasMany { // One to Many Relationship
        return $this->hasMany(stockmodel::class, 'stok_id', 'stok_id');        
    }
}
