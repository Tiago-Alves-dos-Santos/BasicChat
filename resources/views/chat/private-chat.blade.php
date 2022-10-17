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
                        <span class="isRead @if ($value->status_message == 'read') read @else not-read @endif"><i class="fa-sharp fa-solid fa-check-double"></i></span>
                    </div>
                    @endif
                </div>
            </div>
            
        @endforeach

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
        chatText = CKEDITOR.replace('send_message');

        //id do usuario logado
        let auth_id = "{{Auth::id()}}";



        function addMessageSent(message){
            let html = '<div class="message message-sender mt-1">'+
                '             <div class="content">'+
                '                 <p>'+message+'</p>'+
                '                <div class="message-status">'+
                '                   <span class="isRead not-read"><i class="fa-sharp fa-solid fa-check-double"></i></span>'+
                '                </div>'+
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
                '                <div class="message-status">'+
                '                   <span class="isRead not-read"><i class="fa-sharp fa-solid fa-check-double"></i></span>'+
                '                </div>'+
                '             </div>'+
                '         </div>';
            }else{
                html = '<div class="message message-addressee mt-1">'+
                '             <div class="content">'+
                '                 <p>'+message+'</p>'+
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
                        if(chat_mesage){
                            addMessage(chat_mesage, true);
                        }
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

        function messageReads(user_sender, user_addressee){
            $.ajax({
                type: 'POST',
                url:"{{route('control.chat.messageRead')}}",
                data:{
                    "_token": "{{ csrf_token() }}",
                    'user_sender': user_sender,
                    'user_addressee': user_addressee
                },
                beforeSend: function(e){
 
                },
                complete: function(e){
                    // alert('Messagem enviada com sucesso');
                },
                success: function (e) { //mensagens lidas
                    // console.log('sucesso',e)
                }
            });
        }


        function realtimeMessage(){
            window.Echo.private("chat.user.{{Auth::id()}}")
            .listen('Chat\\ChatEvent', (e) => {
                    // console.log(e);
                    let sender = e.user_sender;
                    let adressee = e.user_adressee;
                    let message = e.message;
                    let status_message = e.status_message;

                    if(sender != auth_id){//recebendo, usuario destinatario
                        addMessage(message, false);
                    }

                    if(!document.hidden){
                        // console.log('lida');
                        //fazer request para mensagem lida, usuario sender receber
                        messageReads(e.user_sender, e.user_adressee);
                        
                    }
            })
        }
        
        realtimeMessage();


        function messageReadsListen(){
            window.Echo.private("chat.messageRead.{{Auth::id()}}")
            .listen('Chat\\MessageRead', (e) => {
                    // console.log(e);
                    //mudar mensagens para lidas
                    $("span.isRead").removeClass('not-read');
                    $("span.isRead").addClass('read');

            })
        }

        messageReadsListen();


        //não funciona ao iniciar a pagina
        document.addEventListener("visibilitychange",()=>{
            // console.log(document.visibilityState);
           if(document.visibilityState==="visible"){
                console.log(" >> This window is visible")
                // fazer request e mudar as mensagens não lidas
                messageReads("{{$user->id}}", "{{Auth::id()}}");
                
           }
       })

        
    });
</script>
@endpush
@endsection