<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable; // implemntasi class Authenticatable

class usermodel extends Authenticatable 
{
    public function level() :BelongsTo{
        return $this->belongsTo(LevelModel::class,'level_id','level_id'); //merujuk kepada induk tabel
    }
    
    use HasFactory;

    protected $table = 'm_user'; //Mendefinisikan nama tabel yang digunakan oleh model ini
    protected $primaryKey = 'user_id'; //mendefinisikan primary key dari tabel yang digunakan

    
    protected $fillable = ['level_id','username','nama','password']; //full attribute
    // protected $fillable = ['level_id','username','nama']; // terjadi error karena terdapat kolom yang tidak benar /  salah / belum terinisiasi kan (Dalam kasus ini adalah 'password')

    protected $hidden = ['password']; // jangan ditampilkan saat select

    protected $casts = ['password' => 'hashed']; // casting password agar otomatis di hash
    
    //mendapatkan nama role
    public function getRoleName():string{
        return $this->level->level_nama;
    }

    public function hasRole($role):bool{
        return $this->level && $this->level->level_kode == $role;
    }
}
