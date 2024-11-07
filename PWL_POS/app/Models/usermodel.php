<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\User as Authenticatable; // implemntasi class Authenticatable

class usermodel extends Authenticatable implements JWTSubject
{
    public function level() :BelongsTo{
        return $this->belongsTo(LevelModel::class,'level_id','level_id'); //merujuk kepada induk tabel
    }

    public function getJWTIdentifier(){
        return $this->getKey();
    }

    public function getJWTCustomClaims(){
        return [];
    }
    
    use HasFactory;

    protected $table = 'm_user'; //Mendefinisikan nama tabel yang digunakan oleh model ini
    protected $primaryKey = 'user_id'; //mendefinisikan primary key dari tabel yang digunakan

    
    protected $fillable = ['level_id','username','nama','password','avatar','image']; //full attribute
    // protected $fillable = ['level_id','username','nama']; // terjadi error karena terdapat kolom yang tidak benar /  salah / belum terinisiasi kan (Dalam kasus ini adalah 'password')

    protected $hidden = ['password']; // jangan ditampilkan saat select

    protected $casts = ['password' => 'hashed']; // casting password agar otomatis di hash

    protected function image():Attribute{
        return Attribute::make(
            get: fn ($image) =>url('/storage/posts/'. $image),
        );
    }
    
    //mendapatkan nama role
    public function getRoleName():string{
        return $this->level->level_nama;
    }

    public function hasRole($role):bool{
        return $this->level && $this->level->level_kode == $role;
    }

    public function getRole(){
        return $this->level->level_kode;
    }
}
