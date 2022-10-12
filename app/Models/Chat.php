<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Chat extends Model
{
    use HasFactory;
    use SoftDeletes;
    // protected $table = 'chats';
    protected $fillable = [
        'user_sender',
        'user_addressee',
        'message',
        'status_message',
    ];

    public function user_sender()
    {
        return $this->belongsTo(User::class, 'user_sender');
    }

}
