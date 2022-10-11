<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('includes.header')
<body>
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
    
    @include('includes.footer')
    @stack('scripts')
</body>
</html>