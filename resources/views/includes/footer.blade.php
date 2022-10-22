<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
{{-- <script src="{{mix('js/app.js')}}"></script> --}}
<script src="{{asset('js/footer.js')}}"></script>


@if (session()->has('alert_msg'))
    <script>
        showAlert("{{session('alert_msg.title')}}", "{{session('alert_msg.data')}}", "{{session('alert_msg.type')}}")
    </script>
@php
    session()->forget('alert_msg');
@endphp
@endif

@if (session()->has('toast_msg'))
    <script>
        showToast("{{session('toast_msg.title')}}", "{{session('toast_msg.data')}}", "{{session('toast_msg.type')}}")
    </script>
@php
    session()->forget('toast_msg');
@endphp
@endif

<script>
    

</script>