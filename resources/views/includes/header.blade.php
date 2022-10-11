<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
    <title>BasiChat</title>
    {{-- mix - css - js --}}
    <link rel="stylesheet" href="{{mix('css/app.css')}}">
    {{-- alerts --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    {{-- Fim css --}}
    {{-- scripts --}}
    {{-- font awessome vs4 --}}
    <script src="https://kit.fontawesome.com/4ecb736ddb.js" crossorigin="anonymous"></script>
    {{-- jquery --}}
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    {{-- alerts --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    {{-- ckeditor vs4 --}}
    <script src="{{asset('js/plugins/ckeditor/ckeditor.js')}}" charset="utf-8"></script>
    <script src="{{asset('js/plugins/ckeditor/adapters/jquery.js')}}"></script>
    {{-- fim ckeditor --}}

    {{-- my script --}}
    <script src="{{asset('js/header.js')}}"></script>
    <script src="{{mix('js/app.js')}}"></script>
    {{-- <script src="{{asset('js/pusher.js.map')}}"></script> --}}
    
</head>