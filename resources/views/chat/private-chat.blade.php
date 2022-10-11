@extends('layouts.chat', ['page' => 'chat_privado', 'title_page' => 'Chat Privado', 'user' => $user])

@section('content')
<div id="private_global_chat">
    <div class="mt-5"></div>
   
    <div class="chat-content">
        <div class="message message-addressee">
            <div class="content">
                <p>Olá! Sou a mensagem de quem ta enviando</p>
            </div>
        </div>
        <div class="message message-sender">
            <div class="content">
                <p>Olá! Sou a mensagem de quem ta recebendo</p>
            </div>
        </div>

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

        function enviarMessage(e){
            if(e.data.keyCode == CKEDITOR.SHIFT + 13){
                console.log('enviar');
            }
        }
        chatText.on('key', function(e){
            enviarMessage(e);
        })
    });
</script>
@endpush
@endsection