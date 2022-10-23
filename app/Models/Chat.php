<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
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

    /******************FUNCTIONS******************/
    
    /******************FUNCTIONS STATIC******************/

    //ler mensagens ao carregar a pagina
    public static function readMessageUsers($user_sender, $user_addressee)
    {
        $data = [
            'user_sender' => $user_sender,
            'user_addressee' => $user_addressee
        ];
        Chat::where(function($q) use ($data){
            $q->where('user_addressee', $data['user_sender']);
            $q->where('user_sender', $data['user_addressee']);
            $q->whereIn('status_message', ['sent','received']);
        })
        ->update([
            'status_message' => 'read'
        ]);
    }
    //ler mensagens se possivel apos realtime
    public static function readMessageUsersRealtime($user_sender, $user_addressee)
    {
        $data = [
            'user_sender' => $user_sender,
            'user_addressee' => $user_addressee
        ];
        Chat::where(function($q) use ($data){
            $q->where('user_addressee', $data['user_sender']);
            $q->where('user_sender', $data['user_addressee']);
            $q->whereIn('status_message', ['sent','received']);
        })
        ->orWhere(function($q) use ($data){
            $q->where('user_addressee', $data['user_addressee']);
            $q->where('user_sender', $data['user_sender']);
            $q->whereIn('status_message', ['sent','received']);
        })
        ->update([
            'status_message' => 'read'
        ]);
    }

}
