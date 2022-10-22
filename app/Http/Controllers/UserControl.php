<?php

namespace App\Http\Controllers;

use App\Classes\Configuracao;
use App\Events\Chat\MessageNotRead;
use App\Events\Online;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserControl extends Controller
{
    public function index(Request $request)
    {
        if(Auth::check()){
            return redirect()->route('view.user.lista');
        }else{
            return view('login');
        }
        
    }

    public function viewCadastro(Request $request)
    {
        return view('user.cadastro');
    }

    public function viewLista(Request $request)
    {
        $users = User::where('id','!=', Auth::id())
        ->orderBy('name')
        ->get();
        return view('user.lista', compact(
            'users'
        ));
    }

    public function getMessagesNotReadCounter(Request $request)
    {
        $user_id = $request->user_id;
        
        $user = User::find(Auth::user()->id);

        $user_addressee = User::find($user_id);
        $messages_count = $user->getMessagesNotReadCount($user_addressee);
        if($messages_count > 0){//tem mensagens não lidas
            //evento realtime aq
            broadcast(new MessageNotRead($user_addressee->id, $messages_count, $user->id));
        }
        return [
            // 'user_id' => $user_id,
            // 'user' => $user,
            // 'count_messages_notRead' => $user->getMessagesNotReadCount($user2)
        ];
    }

    public function cadastrar(Request $request)
    {
        $validate = $request->validate([
            'nome' => 'required|min:5|max:255',
            'login' => 'required|min:5|max:30',
        ]);

        $nome = $request->nome;
        $login = $request->login;

        if(!User::where('login', $login)->exists()){
            $user = User::create([
                'name' => $nome,
                'login' => $login,
                'password' => Hash::make('teste')
            ]);
            if(!Auth::check()){
                $retorno = User::login($user->login);
                if($retorno->login){
                    User::where('id', $retorno->user->id)->update([
                        'online' => 'Y'
                    ]);
                    broadcast(new Online($retorno->user->id, 'Y'));
                }
                return redirect()->route('view.user.lista');
            }else{
                session([
                    'alert_msg' => [
                        'title' => 'Sucesso!',
                        'data' => 'Usuário cadastrado com sucesso',
                        'type' => Configuracao::tipoAlerta('success')
                    ]
                ]);
                return redirect()->back();
            }
        }else{//login existente
            session([
                'alert_msg' => [
                    'title' => 'Login existente!',
                    'data' => 'Forneça outro login',
                    'type' => Configuracao::tipoAlerta('error')
                ]
            ]);
            return redirect()->back();
        }

    }

    public function login(Request $request)
    {
        $validate = $request->validate([
            'login' => 'required|min:5|max:30',
        ]);
        $login = $request->login;
        $retorno = User::login($login);
        // dd($retorno);
        if($retorno->login){
            User::where('id', $retorno->user->id)->update([
                'online' => 'Y'
            ]);
            broadcast(new Online($retorno->user->id, 'Y'));
            return redirect()->route('view.user.lista');
        }else{//login existente
            session([
                'alert_msg' => [
                    'title' => $retorno->alert->title,
                    'data' => $retorno->alert->data,
                    'type' => $retorno->alert->type
                ]
            ]);
            return redirect()->back();
        }
    }

    public function logout(Request $request)
    {
        $motivo = $request->motivo ?? null;
        User::where('id', Auth::id())->update([
            'online' => 'N'
        ]);
        broadcast(new Online(Auth::id(), 'N'));
        Auth::logout();
        session()->flush();
        if(!empty($motivo) && $motivo === 'inatividade'){
            session([
                'alert_msg' => [
                    'title' => 'Expulso da sessão!',
                    'data' => 'Você ficou 1 hora inativo',
                    'type' => Configuracao::tipoAlerta('warning')
                ]
            ]);
        }
        return redirect()->route('view.user.login');
    }
}
