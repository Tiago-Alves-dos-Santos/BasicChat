<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('includes.header')
<body>
  @include('includes.load-page')
    <div id="center-page">
        <div class="body_form">
            <div class="card">
                <div class="card-header">
                  {{$title_card}}
                </div>
                <div class="card-body">
                  @yield('center-content')
                </div>
              </div>
        </div>
    </div>
    @include('includes.footer')
</body>
</html>