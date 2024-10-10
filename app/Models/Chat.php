<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    public $table = 'chats';
    use HasFactory;
    protected $fillable = [
        'message',
        'image',
        'video',
        'blogger_id',
        'user_id'
    ];
    public function blog() {
        $this->belongsTo(Blogger::class);
    }
    public function user(){
        $this->belongsTo(User::class);
    }
}
