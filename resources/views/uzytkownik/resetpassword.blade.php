<!DOCTYPE html>
<html lang="pl">
<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<title>RESTART HASŁA</title>
	<meta name="description" content="DEMO BANKU - Żukowski, Męczyński, Żarniewicz">
	<meta name="author" content="Żukowski, Żarniewicz, Męczyński">
	<meta http-equiv="X-Ua-Compatible" content="IE=edge">

	<link rel="stylesheet" href="{{asset('css/app.css')}}">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700&amp;subset=latin-ext" rel="stylesheet">


	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="js/bootstrap.min.js"></script>
     <script src="https://kit.fontawesome.com/285fa7da50.js" crossorigin="anonymous"></script>
</head>

<body>

	<main>

        <div class="container">
            @if($errors->any())
            @include('/layouts/error',['errors'=>$errors->all()])
         @endif
            <div class="row vertical-center">

        <div class="col-md-4 formlog card">
        <p>Wprowadź nowe hasło</p>
              <form action="{{action('UserController@changePassword')}}" method="post">
                  @csrf
                <div class="input-group mb-3">
                  <input type="password" required autofocus name="password" class="form-control" placeholder="HASŁO">
                </div>
                <div class="input-group mb-3">
                  <input type="password" required name="repeat_password" class="form-control" placeholder="POWTÓRZ HASŁO">
                </div>
                <div class="row">
                  <div class="col-8">
                  </div>
                  <div class="col-12">
                    <button type="submit" class="btn btn-primary btn-block">Zapisz zmiany</button>
                  </div>
                </div>
              </form>
        </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                <span style="font-size:12px;color:gray;">Copyright © 2020 WSB - ŻMZ</span>
                </div>
            </div>
        </div>
	</main>
</body>
</html>
