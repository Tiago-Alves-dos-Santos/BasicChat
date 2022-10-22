@extends('layouts.chat', ['page' => 'contatos', 'title_page' => 'Contatos'])

@section('content')
<div id="contatos">
    <div class="mt-5"></div>
    <div class="row mb-5">
        <div class="col-md-12">
            <form action="" method="POST">
                <div class="row">
                    <div class="col-md-11 col-sm-12">
                        <input type="search" class="form-control" placeholder="Buscar...">
                    </div>
                    <div class="col-md col-sm-12">
                        <button type="submit" class="btn btn-primary d-block w-100">
                            Buscar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div id="teste" style="width: 100%; padding: 0 11px; overflow-y: auto; overflow-x: hidden">
        @forelse ($users as $value)
        @php
            $messages_not_read = $value->getMessagesNotReadCount(Auth::user());
        @endphp
        <div class="row contato @if($messages_not_read > 0) blink @endif" data-url="{{route('view.chat.index', ['user_id' => base64_encode($value->id)])}}">
            <div class="col-md-4 text-sm-center text-md-start mt-sm-1">
                <img src="{{asset('img/user-default.png')}}" alt="">
            </div>
            <div class="col-md-4 text-sm-center text-md-center align-self-center">
                <h5>{{$value->name}}</h5>
            </div>
            <div class="col-md-4 text-sm-center text-md-end align-self-center mb-sm-3" id="user-online-{{$value->id}}">
                @switch($value->online)
                    @case('Y')
                    <span class="badge bg-success">Online @if($messages_not_read > 0) - {{$messages_not_read}} @endif</span>
                        @break
                    @case('N')
                    <span class="badge bg-danger">Offline @if($messages_not_read > 0) - {{$messages_not_read}} @endif</span>
                        @break
                    @default
                        
                @endswitch
            </div>
        </div>
        @empty
        <div class="row contato">
            <div class="col-md-12 text-center">
                <h5>Sem contatos</h5>
            </div>
        </div>
        @endforelse
    </div>
</div>

@push('scripts')
<script>
    let height_screen = screen.height - 350;
    $("#teste").css('max-height', height_screen);

    function chatPrivate(){
        $('.contato').on('click', function(){
            let url = $(this).data('url');
            window.location.href = url;
        });
    }
    chatPrivate();

    
</script>
@endpush
@endsection