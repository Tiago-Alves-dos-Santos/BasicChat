<?php

namespace App\Models;

use App\Models\Chat;
use App\Classes\Configuracao;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'login',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    /******************FUNCTIONS******************/
    public function getMessagesNotReadCount($user)
    {
        return Chat::where(function($q) use ($user){
            $q->where('user_sender', $this->id);
            $q->where('user_addressee', $user->id);
            $q->where('status_message', 'received');
        })
        ->count();
    }
    /******************FUNCTIONS STATIC******************/

    public static function login($login)
    {
        $retorno = [
            'login' => false,
            'alert' => [
                'title' => '',
                'data' => '',
                'type' => ''
            ],
            'user' => null
        ];
        if(User::where('login', $login)->exists()){
            $user = User::where('login', $login)->first();
            
            if(!SessionDB::sessionActive($user->id)){
                Auth::login($user);
                //retorno de sucesso
                $retorno['login'] = true;
                $retorno['user'] = $user;
            }else{//usuario já logado
                $retorno['alert']['title'] = 'Usuário já conectado!';
                $retorno['alert']['data'] = 'Tente novamente mais tarde!';
                $retorno['alert']['type'] = Configuracao::tipoAlerta('error');
            }
            
        }else{//login inexistente
            $retorno['alert']['title'] = 'Login inexistente!';
            $retorno['alert']['data'] = 'Realize o cadastro para fazer login!';
            $retorno['alert']['type'] = Configuracao::tipoAlerta('error');
        }

        $retorno['alert'] = (object) $retorno['alert'];
        
        return (object) $retorno;
    }
}
