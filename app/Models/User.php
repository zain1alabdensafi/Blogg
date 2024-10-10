<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public $table='users';
    protected $fillable = [
        'first_name',
        'last_name',
        'nationality',
        'gender',
        'phone',
        'type',
        'image',
        'email',
        'password',
    ];
    public function follower(){
        $this->hasMany(Follower::class,'user_id');
    }
    public function fav(){
        $this->hasMany(Favourite::class,'user_id');
    }
    public function comment(){
        $this->hasMany(Comment::class,'user_id');
    }
    public function interaction(){
        $this->hasMany(Interaction::class,'user_id');
    }

    
   
    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
