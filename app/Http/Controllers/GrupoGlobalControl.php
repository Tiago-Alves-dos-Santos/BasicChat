<?php

namespace App\Http\Controllers;

use App\Events;
use App\Events\GroupGlobal as GroupGlobalEvent;
use App\Events\NotificationGroup;
use App\Models\GrupoGlobal;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GrupoGlobalControl extends Controller
{
    public function index(Request $request)
    {
        $messages = GrupoGlobal::get();
        return view('chat.global-chat', compact(
            'messages'
        ));
    }

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
    
            $group = GrupoGlobal::create([
                'message' => trim($request->chat_message),
                'user_id' => $request->user_id
            ]);
            //realtime messsage
            broadcast(new GroupGlobalEvent($group->message, $group->user_id));
            $user_name = Auth::user()->name;
            $message = "<span style='color:black; text-transform:uppercase;'>$user_name</span> acabou de enviar messagem no grupo";
            //realtime notificação
            broadcast(new NotificationGroup($message));
        } catch (\Exception $e) {
            $result['error'] = $e->getMessage();
        }
        return json_encode($result);
       

    }
}
