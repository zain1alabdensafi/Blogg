<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{
    public $table = 'followers';
    use HasFactory;
    protected $fillable = [
        'blogger_id',
        'user_id'
    ];
    public function user(){
        $this->belongsTo(User::class);
    }
    public function blogger(){
    $this->belongsTo(Blogger::class);
    }
}
