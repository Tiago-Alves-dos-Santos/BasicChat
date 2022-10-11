<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ChatControl extends Controller
{
    public function index(Request $request)
    {
        $user = User::find(base64_decode($request->user_id));
        return view('chat.private-chat', compact(
            'user'
        ));
    }
}
