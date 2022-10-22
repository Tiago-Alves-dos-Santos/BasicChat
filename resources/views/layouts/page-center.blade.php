<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('includes.header')
<body>
  @include('includes.load-page')
    <div id="center-page">
        <div class="body_form">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                  <span style="position: relative;top:5px">{{$title_card}}</span>
                  <button class="btn btn-outline-dark" type="button" data-bs-toggle="modal" data-bs-target="#modalLeiame">
                    Leia-me
                  </button>
                </div>
                <div class="card-body">
                  @yield('center-content')
                </div>
              </div>
        </div>
    </div>
    <x-modal id="modalLeiame" title='Leia-me' :onlyClose='true'>
      <div>
        <h3 class="text-warning text-center">Atenção!</h3>
        <p>
          Este sistema foi criado exclusivamente para <span class="fw-bold">fins demonstrativos</span>, o mesmo deixa muito a desejar para um sistema de chat.<br/>
          O objetivo desse sistema é exemplificar o uso de '<span class="fw-bold">websockets</span>' com laravel, mostrar o uso de canais públicos e privados
        </p>
        <p>
          Para um melhor uso de teste é indicado usar uma <span class="fw-bold">guia anônima</span>, caso esteja usando um único computador.<br/>
          Outro indicação é abrir a aplicação no host e acessar de diferentes máquinas!
        </p>
      </div>
    </x-modal>
    @include('includes.footer')
</body>
</html>