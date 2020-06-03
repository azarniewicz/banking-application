@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">

</div>
<div class="container">
    <div class="row">

        <div class="col-md-12 infobox">
            HISTORIA TRANSAKCJI
            <table class="table col-md-12">
                  <thead>
                    <tr>
                      <th scope="col">DATA</th>
                      <th scope="col">DANE</th>
                      <th scope="col">KWOTA</th>
                      <th scope="col">STAN KONTA PO TRANSAKCJI</th>
                      <th scope="col"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>22/05/2020</td>
                      <td>LOTTO SP. Z O.O</td>
                      <td>+ 42zł</td>
                      <td>55zł</td>
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
                                         <div class="col-md-4 danehist">
                                            <p class="pelement">Dane płatnika</p>


<p class="inftexthist">Numer rachunku płatnika: <span class="next">00000000000000000</span></p>
<p class="inftexthist">Imię i nazwisko: <span class="next">Jan Kowalski</span></p>
<p class="inftexthist">Ulica, numer domu:<span class="next">Kasztanowa 3</span></p>
<p class="inftexthist">Kod pocztowy:<span class="next">66-115</span></p>
<p class="inftexthist">Miejscowość:<span class="next">Paczuszkowo</span></p>

                                        </div>

                                         <div class="col-md-4 danehist">
                                            <p class="pelement">Dane odbiorcy</p>


<p class="inftexthist">Numer rachunku odbiorcy: <span class="next">00000000000000000</span></p>
<p class="inftexthist">Imię i nazwisko: <span class="next">Jan Kowalski</span></p>
<p class="inftexthist">Ulica, numer domu:<span class="next">Kasztanowa 3</span></p>
<p class="inftexthist">Kod pocztowy:<span class="next">66-115</span></p>
<p class="inftexthist">Miejscowość:<span class="next">Paczuszkowo</span></p>

                                        </div>

                                         <div class="col-md-4 danehist">
                                            <p class="pelement">Dane transakcji</p>


<p class="inftexthist">Tytuł przelewu: <span class="next">HAJS ZA DARMO</span></p>
<p class="inftexthist">Data transakcji: <span class="next">22/05/2020</span></p>
<p class="inftexthist">Kwota transakcji:<span class="next">42zł</span></p>
<p class="inftexthist">Saldo po transakcji:<span class="next">55zł</span></p>
<p class="inftexthist">Numer transakcji:<span class="next">23232424242</span></p>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                        </td>
                    </tr>
                      <!-- koniec rozwijanej opcji-->
                      <!-- drugi rekord-->
                                            <tr>
                      <th scope="col">DATA</th>
                      <th scope="col">DANE</th>
                      <th scope="col">KWOTA</th>
                      <th scope="col">STAN KONTA PO TRANSAKCJI</th>
                      <th scope="col"></th>
                    </tr>
                  <tbody>
                    <tr>
                      <td>22/05/2020</td>
                      <td>LOTTO SP. Z O.O</td>
                      <td>+ 42zł</td>
                      <td>55zł</td>
            <!-- ROZWIJANA OPCJA WIĘCEJ drugi przykład-->
                        <td>
            <a class="btn btn-success butths" data-toggle="collapse" href="#collapse2">
                            SZCZEGÓŁY
                </a>

                    <tr>
                       <td colspan="5">
                           <div class="collapse" id="collapse2" >
                                <div class="card card-body col-md-12" style="border:none">
                                    <div class="row">
                                         <div class="col-md-4 danehist">
                                            <p class="pelement">Dane płatnika</p>


<p class="inftexthist">Numer rachunku płatnika: <span class="next">00000000000000000</span></p>
<p class="inftexthist">Imię i nazwisko: <span class="next">Jan Kowalski</span></p>
<p class="inftexthist">Ulica, numer domu:<span class="next">Kasztanowa 3</span></p>
<p class="inftexthist">Kod pocztowy:<span class="next">66-115</span></p>
<p class="inftexthist">Miejscowość:<span class="next">Paczuszkowo</span></p>

                                        </div>

                                         <div class="col-md-4 danehist">
                                            <p class="pelement">Dane odbiorcy</p>


<p class="inftexthist">Numer rachunku odbiorcy: <span class="next">00000000000000000</span></p>
<p class="inftexthist">Imię i nazwisko: <span class="next">Jan Kowalski</span></p>
<p class="inftexthist">Ulica, numer domu:<span class="next">Kasztanowa 3</span></p>
<p class="inftexthist">Kod pocztowy:<span class="next">66-115</span></p>
<p class="inftexthist">Miejscowość:<span class="next">Paczuszkowo</span></p>

                                        </div>

                                         <div class="col-md-4 danehist">
                                            <p class="pelement">Dane transakcji</p>


<p class="inftexthist">Tytuł przelewu: <span class="next">HAJS ZA DARMO</span></p>
<p class="inftexthist">Data transakcji: <span class="next">22/05/2020</span></p>
<p class="inftexthist">Kwota transakcji:<span class="next">42zł</span></p>
<p class="inftexthist">Saldo po transakcji:<span class="next">55zł</span></p>
<p class="inftexthist">Numer transakcji:<span class="next">23232424242</span></p>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                        </td>
                    <!-- koniec rozwijanej opcji drugi przykład-->
                    </tr>
                  </tbody>
             </table>


        </div>
     </div>
</div>
@endsection
