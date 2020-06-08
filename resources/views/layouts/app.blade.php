<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>STRONA GŁÓWNA</title>

    <meta name="description" content="DEMO BANKU - Żukowski, Męczyński, Żarniewicz">
    <meta name="author" content="Żukowski, Żarniewicz, Męczyński">

    <meta http-equiv="X-Ua-Compatible" content="IE=edge">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700&amp;subset=latin-ext" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://kit.fontawesome.com/285fa7da50.js" crossorigin="anonymous"></script>
    <script src="{{asset('js/app.js')}}"> </script>

</head>
<body>
<div id="app">
    @include('layouts.navbar')
    <main>
        @if($errors->any())
            <div class="alert alert-danger text-sm-center" role="alert">
                @foreach($errors->all() as $error)
                    <span class="w-100">{{ $error }}</span>
                    <br>
                @endforeach
            </div>
        @endif
        @if(session()->has('success'))
            <div class="alert alert-success text-sm-center" role="alert">
                <span class="w-100">{{ session()->get('success') }}</span>
            </div>
        @endif
        @yield('content')
    </main>
    <footer>
        @include('layouts.footer')
    </footer>

</div>
    <script>
     Echo.private('ustawienia.{{\Auth::user()->id}}')
        .listen('UstawieniaRedirect', (e) => {
            let user = e.user;
            if(user.is_zablokowana || user.is_reset_password || user.is_reset_pin){
                window.location.href = "/";
            }
         });
    </script>
</body>
</html>
