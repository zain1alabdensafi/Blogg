<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public $table = 'posts';
    use HasFactory;
    protected $fillable = [
    'description',
     'image',
     'video',
     'blogger_id',
     'category_id'
];
public function blogger(){
    $this->belongsTo(Blogger::class);
}
public function fav(){
    $this->hasMany(Favourite::class,'post_id');
}
public function comment(){
    $this->hasMany(Comment::class,'post_id');
}
public function interaction(){
    $this->hasMany(Interaction::class,'post_id');
}
public function category(){
    $this->belongsTo(Category::class);
}
}
