@extends('layouts.page-center', ['title_card' => 'Login'])

@section('center-content')
<form action="{{route('control.user.login')}}" method="POST" class="submit-loadPage" id="form_login">
    @csrf
    <div class="form-row">
        <div class="col-md-12">
            {{-- <label for="">Login:</label> --}}
            <input type="text" class="form-control  @error('login') is-invalid @enderror" name="login" value="{{old('login') ?? ''}}">
            @error('login')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
        </div>
    </div>
    <div class="form-row mt-2">
        <div class="col-md-12 d-flex" style="justify-content: space-between ">
            <a href="{{route('view.user.cadastro')}}">Cadastre-se</a>
            <button type="submit" form="form_login" class="btn btn-primary">
                Entrar
            </button>
        </div>
    </div>
</form>
@endsection