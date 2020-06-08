<!DOCTYPE html>
<html lang="pl">
<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<title>PANEL ADMINISTRATORA</title>
	<meta name="description" content="DEMO BANKU - Żukowski, Męczyński, Żarniewicz">
	<meta name="author" content="Żukowski, Żarniewicz, Męczyński">
	<meta http-equiv="X-Ua-Compatible" content="IE=edge">

	<link rel="stylesheet" href="{{asset('css/app.css')}}">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700&amp;subset=latin-ext" rel="stylesheet">



	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.js"></script>
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/285fa7da50.js" crossorigin="anonymous"></script>









</head>

<body>
	<main>
      <div class="container">
        <div class="row">
          <section class="col-md-12 infobox text-left">

              PANEL ADMINISTRATORA - {{$administrator->nazwisko." ".$administrator->imie}}

              <form action="{{ url('wyloguj') }}" method="post" class="float-right">
                  @csrf
                  <button type="submit" class="btn btn-primary " >WYLOGUJ</button>
              </form>

           <ul class="nav nav-tabs navsset ">

             <li class="nav-item">
               <a class="nav-link active " data-toggle="tab" href="#rejkont" role="tab" aria-selected="true">REJESTRACJA KLIENTÓW</a>
             </li>
             <li class="nav-item">
               <a class="nav-link " data-toggle="tab" href="#werkred" aria-selected="false">WERYFIKACJA KREDYTÓW</a>
             </li>
             <li class="nav-item">
               <a class="nav-link " data-toggle="tab" href="#uzyt" aria-selected="false">UŻYTKOWNICY</a>
             </li>
           </ul>
           @if($errors->any())
              @include('/layouts/error',['errors'=>$errors->all()])
           @endif
           <div class="tab-content">

                <!-- REJESTRACJA UŻYTKOWNIKÓW -->
            <div class="tab-pane fade active show" id="rejkont">
                <div class="col-md-12 przelew-form">

                <form action="{{ action('UserController@store') }}"  method="post">

                    @csrf
                    <div class="col-md-6 mgg">

                        <div class="form-group">
    <input type="text" name="imie" class="form-control" placeholder="Imię"/>
                        </div>

	                    <div class="form-group">
    <input type="text" name="nazwisko" class="form-control" placeholder="Nazwisko"/>
                        </div>

                        <div class="form-group">
                            <input type="text" name="email" class="form-control" placeholder="Email"/>
                                                </div>


	                    <div class="form-group">
    <input type="text" name="pesel" class="form-control" placeholder="Pesel"/>
                        </div>
                        <div class="form-group">
    <input type="text" name="seria_i_numer_dowodu" class="form-control" placeholder="Seria i numer dowodu"/>
                        </div>

	                    <div class="form-group">
    <input type="text" name="nr_telefonu" class="form-control" placeholder="Numer telefonu" />
                        </div>

	                    <div class="form-group">
    <input type="text" name="miasto" class="form-control" placeholder="Miasto"/>
                        </div>

	                    <div class="form-group">
    <input type="text" name="ulica_nr" class="form-control" placeholder="Ulica i numer domu"/>
                        </div>

	                    <div class="form-group">
    <input type="text" name="kod_pocztowy" class="form-control" placeholder="Kod pocztowy" />
                        </div>
                        <div class="form-group">
    <input type="text" name="pin" class="form-control" placeholder="PIN do konta"/>
                        </div>
                       <div class="form-group">
    <input type="text" name="password" class="form-control" placeholder="Tymczasowe hasło"/>
                        </div>

                        <div class="form-group">
    <input type="submit" name="btnSubmit" class="btnContact" value="ZAREJESTRUJ"/>
                        </div>
                    </div>

            </form>
        </div>




            </div>

               <!-- WERYFIKACJA KREDYTOWA -->
            <div class="tab-pane" id="werkred">

                <div class="row">

                <div class="col-md-12">

                    <table class="table col-md-12">
                          <thead>
                            <tr>
                              <th scope="col">IMIĘ NAZWISKO</th>
                              <th scope="col">KWOTA</th>
                              <th scope="col">DATA ZŁOŻENIA WNIOSKU</th>
                              <th scope="col"></th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>Mirosław Witkowski</td>
                              <td>4000zł</td>
                              <td>03/06/2020</td>
                    <!-- ROZWIJANA OPCJA WIĘCEJ-->
                        <td>
                    <a class="btn btn-success butths" data-toggle="collapse" href="#collapse1">
                                    SZCZEGÓŁY
                        </a>

                            <tr>
                               <td colspan="5">
                                   <div class="collapse" id="collapse1" >
                                        <div class="card card-body col-md-12" style="border:none">
                                            <div class="row">
                                    <div class="col-md-6 danehist">
                                        <p class="pelement">Dane osoby składającej wniosek</p>


    <p class="inftexthist">Imię: <span class="next">00000000000000000</span></p>
        <p class="inftexthist">Nazwisko: <span class="next">Jan Kowalski</span></p>
        <p class="inftexthist">Pesel: <span class="next">840000000</span></p>
        <p class="inftexthist">Seria i numer dowodu: <span class="next">ATF 33333</span></p>
        <p class="inftexthist">Numer telefonu: <span class="next">+48  111 111 111</span></p>
        <p class="inftexthist">Ulica, numer domu:<span class="next">Kasztanowa 3</span></p>
        <p class="inftexthist">Kod pocztowy:<span class="next">66-115</span></p>
        <p class="inftexthist">Miejscowość:<span class="next">Paczuszkowo</span></p>

                                    </div>
                                    <div class="col-md-6 danehist przelew-form">
                                        <p class="pelement">INFORMACJE O KREDYCIE</p>

    <p class="inftexthist">KWOTA:<span class="next">4000ZŁ</span></p>
    <p class="inftexthist">Ilość rat: <span class="next">36</span></p>
    <div class="form-group col-md-6">
    <input type="submit" name="btnSubmit" class="btnContact odrz" value="ODRZUĆ" style="background-color:indianred;"/>
    </div>
    <div class="form-group col-md-6">
    <input type="submit" name="btnSubmit" class="btnContact akct" value="ZAAKCEPTUJ" style="background-color:green;"/>
    </div>

                                    </div>

                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </td>
                            </tr>

                              <!--DRUGI REKORD Z DANYMI DO KREDYTU -->
                                <tr>
                              <td>Mirosław Witkowski</td>
                              <td>4000zł</td>
                              <td>03/06/2020</td>
                    <!-- ROZWIJANA OPCJA WIĘCEJ-->
                        <td>
                    <a class="btn btn-success butths" data-toggle="collapse" href="#collapse2">
                                    SZCZEGÓŁY
                        </a>

                            <tr>
                               <td colspan="5">
                                   <div class="collapse" id="collapse2" >
                                        <div class="card card-body col-md-12" style="border:none">
                                            <div class="row">
                                    <div class="col-md-6 danehist">
                                        <p class="pelement">Dane osoby składającej wniosek</p>


        <p class="inftexthist">Imię: <span class="next">00000000000000000</span></p>
        <p class="inftexthist">Nazwisko: <span class="next">Jan Kowalski</span></p>
        <p class="inftexthist">Pesel: <span class="next">840000000</span></p>
        <p class="inftexthist">Seria i numer dowodu: <span class="next">ATF 33333</span></p>
        <p class="inftexthist">Numer telefonu: <span class="next">+48  111 111 111</span></p>
        <p class="inftexthist">Ulica, numer domu:<span class="next">Kasztanowa 3</span></p>
        <p class="inftexthist">Kod pocztowy:<span class="next">66-115</span></p>
        <p class="inftexthist">Miejscowość:<span class="next">Paczuszkowo</span></p>

                                    </div>
                                    <div class="col-md-6 danehist przelew-form">
                                        <p class="pelement">INFORMACJE O KREDYCIE</p>

    <p class="inftexthist">KWOTA:<span class="next">4000ZŁ</span></p>
    <p class="inftexthist">Ilość rat: <span class="next">36</span></p>
        <form>
    <div class="form-group col-md-6">
    <input type="submit" name="btnSubmit" class="btnContact odrz" value="ODRZUĆ" style="background-color:indianred;"/>
    </div>
    <div class="form-group col-md-6">
    <input type="submit" name="btnSubmit" class="btnContact akct" value="ZAAKCEPTUJ" style="background-color:green;"/>
    </div>
        </form>

                                    </div>

                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </td>
                            </tr>

                     </table>


                </div>
             </div>
            </div>
                <!-- UŻYTKOWNICY -->
            <div class="tab-pane" id="uzyt">
                <div class="col-md-8 przelew-form">


                        <div class="form-group" style="margin-bottom:30px;">
    <input type="search" name="name" id="wyszukajUzytkownika" class="form-control" placeholder="Wyszukaj użytkownika" value=""/>

                        </div>

                    <div class="col-md-12 mgg">
                        <table class="table">
                            <thead>
                              <tr>
                                <th scope="col">Lp</th>
                                <th scope="col">Imię</th>
                                <th scope="col">Nazwisko</th>
                                <th scope="col">Email</th>
                                <th scope="col">Funkcja</th>
                              </tr>
                            </thead>
                            <tbody class = 'table-body-uzytkownicy'>

                            </tbody>
                          </table>
                          <div class = 'edit-panel' style = "display:none;">
                          <form action ='{{action('AdministratorController@editUser')}}' method='POST'>
                            @csrf
                                    <div class="form-group">
                                <input type="text" id="imie" name="imie" class="form-control" placeholder="Imię" value="Jan"/>
                                                    </div>
                                <input hidden id="id" name = "id"/>
                                                    <div class="form-group">
                                <input type="text" id="nazwisko" name="nazwisko" class="form-control" placeholder="Nazwisko" value="Kowalski"/>
                                                    </div>

                                                    <div class="form-group">
                                <input type="text" id="email" name="email" class="form-control" placeholder="Email" value="00000000"/>
                                                    </div>
                                                    <div class="form-group">
                                <input type="submit" name="btnSubmit" class="btnContact s" value="ZMIEŃ DANE" />
                                                    </div>
                                                    <div class="form-group">
                                <input type="submit" name="btnSubmit" class="btnContact s" value="ZABLOKUJ" />
                                                    </div>
                                                    <div class="form-group">
                                <input type="submit" name="btnSubmit" class="btnContact s" value="PONOWNA AKTYWACJA" />
                                                    </div>
                                                    <div class="form-group">
                                <input type="submit" name="btnSubmit" class="btnContact s" value="RESTART HASŁA" />
                                                    </div>
                                                    <div class="form-group">
                                <input type="submit" name="btnSubmit" class="btnContact s" value="RESTART PINU" />
                                                 </div>
                            </form>
                          </div>
                    </div>


        </div>





            </div>
           </div>

         </section>
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
    <script>

            function editButton(el){
                let tds = $(el).parents('tr').children();
                $("#id").val(tds[0].getAttribute('data-id'));
                $("#imie").val(tds[1].innerText);
                $("#nazwisko").val(tds[2].innerText);
                $("#email").val(tds[3].innerText);
                let editPanel = $('.edit-panel').show();
            }
            function debounce(func, wait, immediate) {
            var timeout;
            return function() {
                var context = this, args = arguments;
                var later = function() {
                    timeout = null;
                    if (!immediate) func.apply(context, args);
                };
                var callNow = immediate && !timeout;
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
                if (callNow) func.apply(context, args);
            };
        };

        $(function(){
            $("#wyszukajUzytkownika").on('keyup',debounce(function(e){

                $.get(`/uzytkownik/getusersfilter/${e.currentTarget.value}`).then((data)=>{
                    $('.table-body-uzytkownicy').children().remove();
                    data.data.forEach((item,index)=>{
                        $(`<tr>
                            <td data-id='${item.id}'>${index + 1}</td>
                            <td>${item.imie}</td>
                            <td>${item.nazwisko}</td>
                            <td>${item.email}</td>
                            <td><button onclick='editButton(this)' class='btn btn-primary edit-button' class = 'btn btn-primary'>Edycja</button></td>
                        </tr>`).appendTo('.table-body-uzytkownicy');
                    });
                });
            },500))
        })
    </script>
</body>
</html>
