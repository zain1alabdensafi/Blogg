<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $table = 'categories';
    use HasFactory;
    protected $fillable = [
        'type',
        'rate'
    ];
    public function post(){
        $this->hasMany(Post::class, 'category_id');
    }
    public function blog(){
        $this->hasMany(Blogger::class, 'category_id');
    }
}
