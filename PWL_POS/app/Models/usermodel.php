<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class usermodel extends Model
{
    use HasFactory;

    protected $table = 'm_user'; //Mendefinisikan nama tabel yang digunakan oleh model ini
    protected $primaryKey = 'user_id'; //mendefinisikan primary key dari tabel yang digunakan

    
    protected $fillable = ['level_id','username'.'nama','password']; //full attribute
    // protected $fillable = ['level_id','username','nama']; // terjadi error karena terdapat kolom yang tidak benar /  salah / belum terinisiasi kan
}
