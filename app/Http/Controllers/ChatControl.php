<?php

namespace App\Http\Controllers;

use App\Events\Chat\ChatEvent;
use App\Events\Chat\MessageRead;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatControl extends Controller
{
    //busca mensagens por contato selecionado
    public function index(Request $request)
    {
        $user = User::find(base64_decode($request->user_id));

        //marcar msg como lidas qnd entrar
        Chat::readMessageUsers(Auth::id(), $user->id);
        broadcast(new MessageRead($user->id, Auth::id()));
        //buscar mensagens de remetente e destinatario
        $messages = Chat::where(function($q) use ($user){
            $q->where('user_sender', Auth::id());
            $q->where('user_addressee', $user->id);
        })
        ->orWhere(function($q) use ($user){
            $q->where('user_addressee', Auth::id());
            $q->where('user_sender', $user->id);
        })
        ->get();
        // dd($messages);
        return view('chat.private-chat', compact(
            'user',
            'messages'
        ));
    }

    //enviar mensagem
    public function sendMessage(Request $request)
    {
        $result = [
            'error' => null,
            'message' => ''
        ];
        try {
            $validate = $request->validate([
                'chat_message' => 'required',
            ]);
            $user_addressee = $request->user_addressee;
            $user_sender = $request->user_sender;
            $message = $request->chat_message;
    
            $chat = Chat::create([
                'user_sender' => $user_sender,
                'user_addressee' => $user_addressee,
                'message' => $message,
                'status_message' => 'received'
            ]);
            broadcast(new ChatEvent(
                $user_sender,
                $user_addressee,
                $chat->message,
                $chat->status_message
            ));

        } catch (\Exception $e) {
            $result['error'] = $e->getMessage();
        }
        return json_encode($result);


    }


    //ler mensagens apos envio
    public function messageRead(Request $request)
    {
        $user_sender = $request->user_sender;
        $user_addressee = $request->user_addressee;
        Chat::readMessageUsersRealtime($request->user_sender, $request->user_addressee);
        //evento mensagens lidas
        broadcast(new MessageRead($user_sender, $user_addressee));
    }
}
