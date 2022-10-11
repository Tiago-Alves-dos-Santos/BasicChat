<?php

namespace App\Http\Controllers;

use App\Events;
use App\Events\Teste;
use App\Events\GroupGlobal;
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
        // return json_encode([
        //     'data' => 'teste'
        // ]);
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
            // broadcast(new GroupGlobal($group->message, $group->user_id))
            if(broadcast(new Teste())){
                return json_encode($result);
            }   
            // broadcast(new GroupGlobal($group->message, $group->user_id));
            $user_name = Auth::user()->name;
            // Notification::create([
            //     'message' => "<span style='color:blue'>$user_name</span> acabou de enviar messagem no grupo"
            // ]);
            $result['message'] = $group->message;
        } catch (\Exception $e) {
            $result['error'] = $e->getMessage();
        }
        return json_encode($result);
        //realtime notificação

    }
}
