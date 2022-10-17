@extends('layouts.chat', ['page' => 'grupo_global', 'title_page' => 'Grupo'])

@section('content')
<div id="private_global_chat">
    <div class="mt-5"></div>
   
    <div class="chat-content">
        
        @foreach ($messages as $value)
            <div class="message @if ($value->user_id == Auth::id()) message-sender @else message-addressee @endif mt-1">
                <div class="content">
                    @if ($value->user_id != Auth::id())
                    <h6>{{$value->user->name}}</h6>
                    @endif
                    <?= htmlspecialchars_decode($value->message) ?>
                </div>
            </div>
            
        @endforeach

    </div>
    <div class="send-message">
        <form action="">
            <textarea name="chat_message" id="chat_message" ></textarea>
        </form>
    </div>
</div>


@push('scripts')
<script>
    $(function(){

        //id do usuario logado
        let auth_id = "{{Auth::id()}}";

        //definindo ckeditor
        chatText = CKEDITOR.replace('chat_message');


        function addMessageSent(message){
            let html = '<div class="message message-sender mt-1">'+
            '             <div class="content">'+
            '                 <p>'+message+'</p>'+
            '             </div>'+
            '         </div>';

            $('.chat-content').append(html);
        }
        function addMessage(message, sender, user_name = ''){
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
                '    <h6>'+user_name+'</h6>'+
                '                 <p>'+message+'</p>'+
                '             </div>'+
                '         </div>';
            }

            $('.chat-content').append(html);
        }

        function enviarMessage(e){
            let chat_mesage = CKEDITOR.instances['chat_message'].getData();
            if(e.data.keyCode == CKEDITOR.SHIFT + 13){
                $.ajax({
                    type: 'POST',
                    url:"{{route('control.grupo-global.sendMessage')}}",
                    data:{
                        "_token": "{{ csrf_token() }}",
                        'chat_message': chat_mesage,
                        'user_id': "{{Auth::id()}}"
                    },
                    beforeSend: function(e){
                        // if(chat_mesage){
                        //     addMessageSent(chat_mesage);
                        // }
                        CKEDITOR.instances['chat_message'].setData('');
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
                    //não precisa pois estou tratando no back-end
                    // error: function (e) {
                    //     console.log('errro',e);
                    //     showAlert("Erro escopo certo!", e, 0);
                    
                    // }
                });

            }
        }

        //evento de tecla pressionada
        chatText.on('key', function(e){
            enviarMessage(e);
        })
        function realtimeMessage(){
            window.Echo.channel("grupo.global")
            .listen('GroupGlobal', (e) => {
                    let sender = e.sender;
                    let message = e.message;
                    let name = e.user_name;

                    if(sender == auth_id){//enviando
                        addMessage(message, true);
                    }else{//recebendo
                        addMessage(message, false, name);
                    }
            })
        }
        
        realtimeMessage();
    });
</script>
@endpush
@endsection