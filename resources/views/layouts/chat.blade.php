<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('includes.header')
<body data-page="{{$page}}">
    <div id="chat-page">
        <div class="sidebar">
            <div class="link-container">
                <a href="{{route('view.grupo-global.index')}}" class="@if($page == 'grupo_global') active @endif">Grupo Global</a>
            </div>
            <div class="link-container">
                <a href="{{route('view.user.lista')}}" class="@if($page == 'contatos') active @endif">Contatos</a>
            </div>
            <div class="link-container">
                <a href="#" class="@if($page == 'chat_privado') active @else disable @endif">Chat Privado</a>
            </div>
            <div class="link-container">
                <a href="{{route('control.user.logout')}}" class="logout">Sair</a>
            </div>
            <div class="info-user">
                <h6>{{Auth::user()->name}}</h6>
            </div>
        </div>
        <div class="contents">
            <div class="title shadow">
                <h2>{{$title_page}} @if(!empty($user)) - {{$user->name}} @endif</h2>
            </div>
            <div class="body">
                @yield('content')
            </div>
        </div>
    </div>
    @stack('scripts')
    <script>
        $(function(){
            function isNotPageGroupExecute(function_callback){
                let page_actual = $("body").data('page');

                if(page_actual != 'grupo_global'){
                    function_callback();
                }
            }
            function messageGroupAlert(){
                window.Echo.channel("notification.group")
                .listen('NotificationGroup', (e) => {
                        showToast('Mensagem no grupo', e.message, tipoToast('info'));
                })
            }

            isNotPageGroupExecute(messageGroupAlert);
        });
    </script>
    @include('includes.footer')

    
</body>
</html>