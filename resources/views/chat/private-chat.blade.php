@extends('layouts.chat', ['page' => 'chat_privado', 'title_page' => 'Chat Privado', 'user' => $user])

@section('content')
<div id="private_global_chat">
    <div class="mt-5"></div>
   
    <div class="chat-content">

        @foreach ($messages as $value)
            <div class="message @if ($value->user_sender == Auth::id()) message-sender @else message-addressee @endif mt-1">
                <div class="content">
                    <?= htmlspecialchars_decode($value->message) ?>

                    @if ($value->user_sender == Auth::id())
                    <div class="message-status">
                        <span class="@if ($value->status_message == 'read') read @else not-read @endif"><i class="fa-sharp fa-solid fa-check-double"></i></span>
                    </div>
                    @endif
                </div>
            </div>
            
        @endforeach
        {{-- <div class="message message-addressee">
            <div class="content">
                <p>Olá! Sou a mensagem de quem ta enviando</p>
            </div>

            
        </div>
        <div class="message message-sender">
            <div class="content">
                <p>Olá! Sou a mensagem de quem ta recebendo</p>
                <div class="message-status">
                    <span class="read"><i class="fa-sharp fa-solid fa-check-double"></i></span>
                </div>
            </div>
        </div> --}}

    </div>
    <div class="row mt-5">
        <div class="col-md-12">
            <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-message" aria-expanded="false" aria-controls="collapseExample">
                Esconder/Mostrar
            </button>
        </div>
    </div>
    <div class="send-message collapse show" id="collapse-message">
        <form action="">
            <textarea name="send_message" id="send_message" ></textarea>
        </form>
    </div>
</div>

@push('scripts')
<script>
    $(function(){
        
        let height_screen = screen.height - 690;
        $(".chat-content").css('max-height', height_screen);
        chatText = CKEDITOR.replace('send_message');

        //id do usuario logado
        let auth_id = "{{Auth::id()}}";



        function addMessageSent(message){
            let html = '<div class="message message-sender mt-1">'+
            '             <div class="content">'+
            '                 <p>'+message+'</p>'+
            '             </div>'+
            '         </div>';

            $('.chat-content').append(html);
        }
        function addMessage(message, sender){
            let html = '';
            if(sender){
                html = '<div class="message message-sender mt-1">'+
                '             <div class="content">'+
                '                 <p>'+message+'</p>'+
                '             </div>'+
                '         </div>';
            }else{
                html = '<div class="message message-addressee mt-1">'+
                '             <div class="content">'+
                '                 <p>'+message+'</p>'+
                '                <div class="message-status">'+
                '                   <span class="not-read"><i class="fa-sharp fa-solid fa-check-double"></i></span>'+
                '                </div>'+
                '             </div>'+
                '         </div>';
            }

            $('.chat-content').append(html);
        }

        function enviarMessage(e){
            let chat_mesage = CKEDITOR.instances['send_message'].getData();
            if(e.data.keyCode == CKEDITOR.SHIFT + 13){
                $.ajax({
                    type: 'POST',
                    url:"{{route('control.chat.sendMessage')}}",
                    data:{
                        "_token": "{{ csrf_token() }}",
                        'chat_message': chat_mesage,
                        'user_sender': "{{Auth::id()}}",
                        'user_addressee': "{{$user->id}}"
                    },
                    beforeSend: function(e){
                        CKEDITOR.instances['send_message'].setData('');
                    },
                    complete: function(e){
                        // alert('Messagem enviada com sucesso');
                    },
                    success: function (e) {
                        // console.log('sucesso',e);
                        let json_response = JSON.parse(e);
                        
                        if (json_response.error) {
                            showAlert("Erro!", json_response.error, 0);
                        }
                    }
                });
            }
        }

        //evento de tecla pressionada
        chatText.on('key', function(e){
            enviarMessage(e);
        })

        function realtimeMessage(){
            window.Echo.channel("chat.user."+auth_id)
            .listen('ChatEvent', (e) => {
                    console.log(e);
                    let sender = e.user_sender;
                    let adressee = e.user_adressee;
                    let message = e.message;
                    let status_message = e.status_message;

                    if(sender == auth_id){//enviando
                        addMessage(message, true);
                    }else{//recebendo
                        addMessage(message, false);
                    }
            })
        }
        
        realtimeMessage();
    });
</script>
@endpush
@endsection