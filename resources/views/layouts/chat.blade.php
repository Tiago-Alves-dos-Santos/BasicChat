<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('includes.header')
<body data-page="{{$page}}">
    @include('includes.load-page')
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
                <h6>{{Auth::user()->name}} <span id="timer"></span></h6>
            </div>
        </div>
        <div class="contents">
            <div class="title shadow">
                <div class="menu-mobile">
                    <a href="#" id="toogle-sidebar">
                        <i class="fa-sharp fa-solid fa-bars"></i>
                    </a>
                </div>

                <h2>
                    {{$title_page}} 
                    @if(!empty($user)) 
                    - {{$user->name}}
                        <div id="user-chat-online-{{$user->id}}">
                            @switch($user->online)
                                @case('Y')
                                <span class="badge bg-success">Online</span>
                                    @break
                                @case('N')
                                <span class="badge bg-danger">Offline</span>
                                    @break
                                @default
                                    
                            @endswitch
                        </div>
                        
                    @endif
                </h2>
            </div>
            <div class="body">
                @yield('content')
            </div>
        </div>
    </div>
    @stack('scripts')
    <script>
        $(function(){
            function isNotPageExecute(function_callback, page_not_execute){
                let page_actual = $("body").data('page');

                if(page_actual != page_not_execute){
                    function_callback();
                }
            }
            //escutar notificação de mensagem mandada em grupo, caso vc não esteja na pagina do grupo
            function messageGroupAlert(){
                window.Echo.channel("notification.group")
                .listen('NotificationGroup', (e) => {
                        showToast('Mensagem no grupo', e.message, tipoToast('info'));
                })
            }

            isNotPageExecute(messageGroupAlert ,'grupo_global');
            //evento de escutar se usuario ainda esta online ou não
            function onlineListen(){
                window.Echo.channel("online.listen")
                    .listen('Online', (e) => {
                        // console.log(e);
                        if(e.online){
                            $("#user-online-"+e.user_id).html('<span class="badge bg-success">Online</span>');
                            $("#user-chat-online-"+e.user_id).html('<span class="badge bg-success">Online</span>');
                        }else{
                            $("#user-online-"+e.user_id).html('<span class="badge bg-danger">Offline</span>');
                            $("#user-chat-online-"+e.user_id).html('<span class="badge bg-danger">Offline</span>');
                        }
                    })
            }
            onlineListen();

            //verfica initivadade
            const inactivityTime = function () {
                let time;
                let cont = 0;
                // reset timer
                window.onload = resetTimer;//pagina aberta ou recarregada
                //movimentação do mouse
                document.onmousemove = resetTimer;
                document.onkeydown = resetTimer;
                display = $('#timer'); // selecionando o timer
                function logout() {
                    window.location.href = "{{route('control.user.logout',['motivo' => 'inatividade'])}}";
                }
                function resetTimer() {
                    clearTimeout(time);
                    //tempo de inatividade em segundos
                    let minuto = 60; //uma hora
                    let inatividade_time =  (minuto * 60) * 1000;

                    time = setTimeout(logout, inatividade_time)
                }
            };

            inactivityTime();

            function toggleSidebar(){
                $("#toogle-sidebar").on('click', function(e){
                    e.preventDefault();
                    let left = $("#chat-page div.sidebar").css('left');
                    let width = $("#chat-page div.sidebar").css('width');
                    left = left.replace("px","");
                    width = width.replace("px","");
                    let icon = "";
                    if(left < 0){//mostrar sidebar
                        left *= -1;
                        $("#chat-page div.sidebar").css('left', 0);
                        $("#chat-page div.contents").css('width', 'calc(100% -'+left+'px)');
                        $("#chat-page div.contents").css('left', left+'px');
                        icon = '<i class="fa-solid fa-xmark"></i>';
                    }else{//esconder sidebaer
                        left = width * -1;
                        $("#chat-page div.sidebar").css('left', left+'px');
                        $("#chat-page div.contents").css('width', '100%');
                        $("#chat-page div.contents").css('left', '0px');
                        icon = '<i class="fa-sharp fa-solid fa-bars"></i>';
                    }

                    $(this).html(icon);
                });
            }
            toggleSidebar();
            function endScrollChat(){
                div = $('div.chat-content')[0];
                div.scrollTop = div.scrollHeight;
            }

            isNotPageExecute(endScroll ,'contatos');

            
            
        });
    </script>
    @include('includes.footer')

    
</body>
</html>