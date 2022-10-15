@extends('layouts.page-center', ['title_card' => 'Cadastrar Usuário'])

@section('center-content')
<form action="{{route('control.user.cadastrar')}}" method="POST" id="form_login">
    @csrf
    <div class="form-row">
        <div class="col-md-12">
            <label for="">Nome*:</label>
            <input type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" value="{{old('nome') ?? ''}}">
            @error('nome')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
        </div>
    </div>
    <div class="form-row">
        <div class="col-md-12">
            <label for="">Login*:</label>
            <input type="text" class="form-control @error('login') is-invalid @enderror" name="login" value="{{old('login') ?? ''}}" onkeyup="semEspaco(this)">
            <span class="fw-light">Este campo não aceita caracteres especiais!</span>
            @error('login')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
        </div>
    </div>
    <div class="form-row mt-2">
        <div class="col-md-12 d-flex" style="justify-content: space-between ">
            <a href="{{route('view.user.login')}}">Entrar</a>
            <button type="submit" form="form_login" class="btn btn-primary">
                Cadastrar
            </button>
        </div>
    </div>
  </form>
@endsection