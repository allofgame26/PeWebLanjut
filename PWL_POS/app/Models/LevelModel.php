<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LevelModel extends Model
{
    public function user():BelongsTo{
        return $this->belongsTo(usermodel::class);
    }
    use HasFactory;

    protected $table = 'm_level'; //Mendefinisikan nama tabel yang digunakan oleh model ini
    protected $primaryKey = 'level_id'; //mendefinisikan primary key dari tabel yang digunakan

    
    protected $fillable = ['level_kode','level_nama'];
}
