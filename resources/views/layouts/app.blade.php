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
</head>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="js/bootstrap.min.js"></script>
 <script src="https://kit.fontawesome.com/285fa7da50.js" crossorigin="anonymous"></script>

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
            @yield('content')
        </main>
        <footer>
            @include('layouts.footer')
        </footer>

    </div>
</body>
</html>
