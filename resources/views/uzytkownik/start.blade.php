@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 maine">

Nr klienta: <span>123456</span> Ostatnie logowanie: <span>05/22/2020</span>Aktualna sesja: <span>01:50</span>

        </div>
        <div class="col-md-12 maine">

            <span class="powitanie" >Witaj, <span style="color:#30333b;font-weight: bolder;">{{ auth()->user()->pelne_imie }}</span></span>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12 infobox">
            Informacje o koncie

            <p class="inftext">TYP RACHUNKU: <span class="tresc">{{ $rachunek->typ }}</span></p>
            <div class="dropdown-divider"></div>
            <p class="inftext">Saldo:<span class="tresc">{{ $rachunek->saldo }} zł</span></p>
            <div class="dropdown-divider"></div>
            <p class="inftext">Dostępne środki:<span class="tresc">{{ $rachunek->dostepne_srodki }} zł</span></p>
            <div class="dropdown-divider"></div>
            <p class="inftext">Numer rachunku:<span class="tresc">{{ $rachunek->nr_rachunku }}</span></p>
            <div class="dropdown-divider"></div>
            <p class="inftext">Numer karty:<span class="tresc">00 000 00000 000000</span></p>
        </div>
        <div class="col-md-12 infobox">
            Ostatnie transakcje
            <table class="table">
                  <thead>
                    <tr>
                      <th scope="col">DATA</th>
                      <th scope="col">TYP</th>
                      <th scope="col">KWOTA</th>
                      <th scope="col">SALDO PO TRANSAKCJI</th>
                      <th scope="col">TYTUŁ</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach($ostatnieTransakcje as $transakcja)
                    <tr>
                      <th scope="row">{{ $transakcja->data_wykonania }}</th>
                      <th scope="row">{{ $transakcja->typ }}</th>
                      <td>{{ $transakcja->kwota }}zł</td>
                      <td>{{ $transakcja->saldo_po_transakcji }}zł</td>
                      <td>{{ $transakcja->tytul }}</td>
                    </tr>
                  @endforeach
             </table>

            <a href="{{url('historia')}}"><button type="button" class="btn btn-dark mb-3">Zobacz więcej..</button></a>

        </div>
     </div>
</div>
@endsection
