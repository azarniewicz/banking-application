<!DOCTYPE html>
<html lang="pl">
<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<title>LOGOWANIE DO BANKU</title>
	<meta name="description" content="DEMO BANKU - Żukowski, Męczyński, Żarniewicz">
	<meta name="author" content="Żukowski, Żarniewicz, Męczyński">
	<meta http-equiv="X-Ua-Compatible" content="IE=edge">

	<link rel="stylesheet" href="{{asset('css/app.css')}}">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700&amp;subset=latin-ext" rel="stylesheet">


	<script>

	$( document ).ready( function () {
		$( '.dropdown' ).on( 'click', function ( e ) {
			var $el = $( this );
			var $parent = $( this ).offsetParent( ".dropdown-menu" );
			if ( !$( this ).next().hasClass( 'show' ) ) {
				$( this ).parents( '.dropdown-menu' ).first().find( '.show' ).removeClass( "show" );
			}
			var $subMenu = $( this ).next( ".dropdown-menu" );
			$subMenu.toggleClass( 'show' );

			$( this ).parent( "li" ).toggleClass( 'show' );

			$( this ).parents( 'li.nav-item.dropdown.show' ).on( 'hidden.bs.dropdown', function ( e ) {
				$( '.dropdown-menu .show' ).removeClass( "show" );
			} );

			 if ( !$parent.parent().hasClass( 'navbar-nav' ) ) {
				$el.next().css( { "top": $el[0].offsetTop, "left": $parent.outerWidth() - 4 } );
			}

			return false;
		} );
	} );

	</script>

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="js/bootstrap.min.js"></script>
     <script src="https://kit.fontawesome.com/285fa7da50.js" crossorigin="anonymous"></script>
</head>

<body>

	<main>
        <div class="container">
            <div class="row vertical-center">

        <div class="col-md-4 formlog card">
        <p>LOGOWANIE</p>
              <form action="" method="post">
                  @csrf
                <div class="input-group mb-3">
                  <input type="email" required autofocus name="email" class="form-control" placeholder="LOGIN">
                </div>
                <div class="input-group mb-3">
                  <input type="password" required name="password" class="form-control" placeholder="HASŁO">
                </div>
                <div class="row">
                  <div class="col-8">
                  </div>
                  <div class="col-12">
                    <button type="submit" class="btn btn-primary btn-block">Zaloguj</button>
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
