<!DOCTYPE html>
<html lang="pl">
<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<title>PANEL ADMINISTRATORA</title>
	<meta name="description" content="DEMO BANKU - Żukowski, Męczyński, Żarniewicz">
	<meta name="author" content="Żukowski, Żarniewicz, Męczyński">
	<meta http-equiv="X-Ua-Compatible" content="IE=edge">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700&amp;subset=latin-ext" rel="stylesheet">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>

    <script src="https://kit.fontawesome.com/285fa7da50.js" crossorigin="anonymous"></script>
    <script src="{{asset('js/app.js')}}"> </script>
</head>

<body>
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
           <div class="tab-content">

                <!-- REJESTRACJA UŻYTKOWNIKÓW -->
            <div class="tab-pane fade active show" id="rejkont">
                <div class="col-md-12 przelew-form">

                <form action="{{ action('AdministratorController@storeUzytkownik') }}"  method="post">

                    @csrf
                    <div class="col-md-6 mgg">

                        <div class="form-group">
    <input type="text" name="imie" class="form-control" value="{{ old('imie') }}" placeholder="Imię"/>
                        </div>

	                    <div class="form-group">
    <input type="text" name="nazwisko" class="form-control"  value="{{ old('nazwisko') }}" placeholder="Nazwisko"/>
                        </div>

                        <div class="form-group">
                            <input type="text" name="email" value="{{ old('email') }}" class="form-control" placeholder="Email"/>
                                                </div>


	                    <div class="form-group">
    <input type="text" name="pesel" class="form-control" value="{{ old('pesel') }}" placeholder="Pesel"/>
                        </div>
                        <div class="form-group">
    <input type="text" name="nr_dowodu" class="form-control" value="{{ old('nr_dowodu') }}" placeholder="Seria i numer dowodu"/>
                        </div>

	                    <div class="form-group">
    <input type="text" name="nr_telefonu" class="form-control" value="{{ old('nr_telefonu') }}" placeholder="Numer telefonu" />
                        </div>

	                    <div class="form-group">
    <input type="text" name="miasto" class="form-control" value="{{ old('miasto') }}" placeholder="Miasto"/>
                        </div>

	                    <div class="form-group">
    <input type="text" name="ulica_nr" class="form-control" value="{{ old('ulica_nr') }}" placeholder="Ulica i numer domu"/>
                        </div>

	                    <div class="form-group">
    <input type="text" name="kod_pocztowy" class="form-control" value="{{ old('kod_pocztowy') }}" placeholder="Kod pocztowy" />
                        </div>
                        <div class="form-group">
    <input type="text" name="pin" class="form-control" value="{{ old('pin') }}" placeholder="PIN do konta"/>
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
                            @forEach($wnioski as $wniosek)
                            <tr>
                              <th scope="col">IMIĘ NAZWISKO</th>
                              <th scope="col">KWOTA</th>
                              <th scope="col">DATA ZŁOŻENIA WNIOSKU</th>
                              <th scope="col"></th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>{{$wniosek->imie." ".$wniosek->nazwisko}}</td>
                              <td>{{$wniosek->kwota_kredytu}}</td>
                              <td>{{$wniosek->data_wniosku}}</td>
                    <!-- ROZWIJANA OPCJA WIĘCEJ-->
                        <td>
                        <a class="btn btn-success"

                        data-toggle="collapse" href="#collapse{{$wniosek->id_kredytu}}">
                                    SZCZEGÓŁY
                        </a>

                            <tr style = "height:10px;">
                               <td colspan="5">
                                   <div class="collapse multi-collapse" id="collapse{{$wniosek->id_kredytu}}" >
                                        <div class="card card-body col-md-12" style="border:none">
                                            <div class="row">
                                    <div class="col-md-6 danehist">
                                        <p class="pelement">Dane osoby składającej wniosek</p>


                                        <p class="inftexthist">Imię: <span class="next">{{$wniosek->imie}}</span></p>
                                            <p class="inftexthist">Nazwisko: <span class="next">{{$wniosek->nazwisko}}</span></p>
                                            <p class="inftexthist">Pesel: <span class="next">{{$wniosek->pesel}}</span></p>
                                            <p class="inftexthist">Seria i numer dowodu: <span class="next">{{$wniosek->seria_i_numer_dowodu}}</span></p>
                                            <p class="inftexthist">Numer telefonu: <span class="next">{{$wniosek->nr_telefonu}}</span></p>
                                            <p class="inftexthist">Ulica, numer domu:<span class="next">{{$wniosek->ulica_nr}}</span></p>
                                            <p class="inftexthist">Kod pocztowy:<span class="next">{{$wniosek->kod_pocztowy}}</span></p>
                                            <p class="inftexthist">Miejscowość:<span class="next">{{$wniosek->miasto}}</span></p>

                                    </div>
                                    <div class="col-md-6 danehist przelew-form">
                                        <p class="pelement">INFORMACJE O KREDYCIE</p>

                                            <p class="inftexthist">KWOTA:<span class="next">{{$wniosek->kwota_kredytu}} zł</span></p>
                                            <p class="inftexthist">Ilość rat: <span class="next">{{$wniosek->ilosc_rat}}</span></p>
                                            <div class="form-group col-md-6" style="margin-bottom:0;">
                                            <form action="{{action('KredytController@odrzucWniosek',['id'=>$wniosek->id_kredytu])}}" method="POST">
                                                 @csrf
                                                <input type="submit" name="btnSubmit" class="btnContact odrz" value="ODRZUĆ" style="background-color:indianred;"/>
                                            </form>

                                            </div>
                                            <div class="form-group col-md-6">
                                            <form action="{{action('KredytController@zaakceptujWniosek',['id'=>$wniosek->id_kredytu])}}" method="POST">
                                                @csrf
                                                <input type="submit" name="btnSubmit" class="btnContact akct" value="ZAAKCEPTUJ" style="background-color:green;"/>
                                            </form>

                                            </div>

                                    </div>

                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </td>
                            </tr>
                            @endforeach


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
                <div class="col-md-10 przelew-form">


                        <div class="form-group" style="margin-bottom:30px;">
    <input type="search" name="name" id="wyszukajUzytkownika" class="form-control" placeholder="Wyszukaj użytkownika" value=""/>

                        </div>

                    <div class="col-md-12 mgg">
                        <table class="table d-none" id="lista-uzytkownikow">
                            <thead>
                              <tr>
                                <th scope="col">Lp</th>
                                <th scope="col">Imię</th>
                                <th scope="col">Nazwisko</th>
                                <th scope="col">Email</th>
                                <th scope="col">Funkcja</th>
                              </tr>
                            </thead>
                            <tbody class = 'table-body-uzytkownicy' style="text-transform:none;">

                            </tbody>
                          </table>
                          <div class = 'edit-panel' style = "display:none;">
                          <form action ='{{action('AdministratorController@updateUzytkownik')}}' method='POST'>
                            @csrf
                            {{ method_field('PATCH') }}
                                <input hidden id="id" name = "id"/>
                                                    <div class="form-group">

                        <div class="form-group">
    <input type="text" id="editimie" name="imie" class="form-control" placeholder="Imię"/>
                        </div>

	                    <div class="form-group">
    <input type="text" id="editnazwisko" name="nazwisko" class="form-control" placeholder="Nazwisko"/>
                        </div>

                        <div class="form-group">
                            <input type="text" id="editemail" name="email" class="form-control" placeholder="Email"/>
                                                </div>


	                    <div class="form-group">
    <input type="text" id="editpesel" name="pesel" class="form-control" placeholder="Pesel"/>
                        </div>
                        <div class="form-group">
    <input type="text" id="editnr_dowodu" name="nr_dowodu" class="form-control" placeholder="Seria i numer dowodu"/>
                        </div>

	                    <div class="form-group">
    <input type="text" id="editnr_telefonu" name="nr_telefonu" class="form-control" placeholder="Numer telefonu" />
                        </div>

	                    <div class="form-group">
    <input type="text"  id="editmiasto" name="miasto" class="form-control" placeholder="Miasto"/>
                        </div>

	                    <div class="form-group">
    <input type="text" id="editulica_nr" name="ulica_nr" class="form-control" placeholder="Ulica i numer domu"/>
                        </div>

	                    <div class="form-group">
    <input type="text" id="editkod_pocztowy" name="kod_pocztowy" class="form-control" placeholder="Kod pocztowy" />
                        </div>
                       <div class="form-group">
    <input type="text" id="editpassword" name="tymczasowe_haslo" class="form-control" placeholder="Tymczasowe hasło"/>
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
                console.log(tds);
                $("#id").val(tds[0].getAttribute('data-id'));
                $("#editimie").val(tds[1].innerText);
                $("#editnazwisko").val(tds[2].innerText);
                $("#editemail").val(tds[3].innerText);
                $("#editpesel").val(tds[4].innerText);
                $("#editnr_dowodu").val(tds[5].innerText);
                $("#editnr_telefonu").val(tds[6].innerText);
                $("#editmiasto").val(tds[7].innerText);
                $("#editulica_nr").val(tds[8].innerText);
                $("#editkod_pocztowy").val(tds[9].innerText);
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
                            <td data-id='${item.id_uzytkownika}'>${index + 1}</td>
                            <td>${item.imie}</td>
                            <td>${item.nazwisko}</td>
                            <td>${item.email}</td>
                            <td style="display:none">${item.pesel}</td>
                            <td style="display:none">${item.nr_dowodu}</td>
                            <td style="display:none">${item.nr_telefonu}</td>
                            <td style="display:none">${item.miasto}</td>
                            <td style="display:none">${item.ulica_nr}</td>
                            <td style="display:none">${item.kod_pocztowy}</td>
                            <td><button onclick='editButton(this)' class='btn btn-primary edit-button' class = 'btn btn-primary'>Edycja</button></td>
                        </tr>`).appendTo('.table-body-uzytkownicy');
                    });

                    $('#lista-uzytkownikow').removeClass('d-none');
                });
            },500))
        })
    </script>
</body>
</html>
