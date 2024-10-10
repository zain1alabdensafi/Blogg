<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Blogger extends Model
{
   public $table = 'bloggers';
    use HasApiTokens,HasFactory;
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
        'category_id'
    ];
    public function category(){
        $this->belongsTo(Category::class);
    }
    public function followers(){
        $this->hasMany(Follower::class,'blogger_id');
    }
    public function chat(){
        $this->hasMany(Chat::class,'blogger_id');
    }
    public function post(){
        $this->hasMany(Post::class,'blogger_id');
    }

    
}
