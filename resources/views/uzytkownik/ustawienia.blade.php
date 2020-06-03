@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 maine">

Nr klienta: <span>123456</span> Ostatnie logowanie: <span>05/22/2020</span>Aktualna sesja: <span>01:50</span>

        </div>
        <div class="col-md-12 maine">

            <span class="powitanie" >Witaj, <span style="color:#30333b;font-weight: bolder;">Mirosław Bonk</span></span>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12 infobox">
            Informacje o koncie

            <p class="inftext">TYP RACHUNKU: <span class="tresc">STANDARD</span></p>
            <div class="dropdown-divider"></div>
            <p class="inftext">Saldo dostępne: <span class="tresc">55zł</span></p>
            <div class="dropdown-divider"></div>
            <p class="inftext">Saldo bieżące:<span class="tresc">225zł</span></p>
            <div class="dropdown-divider"></div>
            <p class="inftext">Numer rachunku:<span class="tresc">00 0000 0000 0000 0000 0000 0000 0000</span></p>
            <div class="dropdown-divider"></div>
            <p class="inftext">Numer karty:<span class="tresc">00 000 00000 000000</span></p>
            <div class="dropdown-divider"></div>
            <p class="inftext">Limit dzienny:<span class="tresc">500zł</span></p>
            <div class="dropdown-divider"></div>
            <p class="inftext">Limit miesięczny<span class="tresc">3000zł</span></p>

        </div>
        <div class="col-md-12 infobox">
            Ostatnie transakcje
            <table class="table">
                  <thead>
                    <tr>
                      <th scope="col">DATA</th>
                      <th scope="col">DANE</th>
                      <th scope="col">KWOTA</th>
                      <th scope="col">SALDO PO TRANSAKCJI</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <th scope="row">22/05/2020</th>
                      <td>LOTTO SP. Z O.O</td>
                      <td>+ 42zł</td>
                      <td>55zł</td>
                    </tr>
                    <tr>
                      <th scope="row">21/05/2020</th>
                      <td>LIDL POLSKA</td>
                      <td>- 100,21zł</td>
                      <td>13zł</td>
                    </tr>
                    <tr>
                      <th scope="row">19/05/2020</th>
                      <td>MEBLE BOCIEK</td>
                      <td>- 465,30zł</td>
                      <td>141,21zł</td>
                    </tr>
                    <tr>
                      <th scope="row">18/05/2020</th>
                      <td>Mirosław Szyper</td>
                      <td>+ 50zł</td>
                      <td>606,51zł</td>
                    </tr>
                  </tbody>
             </table>
            <a href="{{url('historia')}}"><button type="button" class="btn btn-dark">Zobacz więcej..</button></a>

        </div>
     </div>
</div>
@endsection

