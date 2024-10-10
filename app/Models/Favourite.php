<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    public $table = 'favourites';
    use HasFactory;
    protected $fillable = [
        'post_id',
        'user_id'
    ];
    public function post(){
        $this->belongsTo(Post::class);
    }
    public function user(){
        $this->belongsTo(User::class);
    }

}
