@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-md-12 infobox">
                    HISTORIA TRANSAKCJI
                    <table class="table col-md-12">
                        <thead>
                        <tr>
                            <th scope="col">DATA</th>
                            <th scope="col">TYP</th>
                            <th scope="col">KWOTA</th>
                            <th scope="col">STAN KONTA PO TRANSAKCJI</th>
                            <th scope="col">TYTUŁ</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($transakcje as $key => $transakcja)
                            <tr>
                                <td>{{ $transakcja->data_wykonania->toDateString() }}</td>
                                <td>{{ $transakcja->typ }}</td>
                                <td>{{ $transakcja->kwota }} zł</td>
                                <td>{{ $transakcja->saldo_po_transakcji }} zł</td>
                                <td>{{ $transakcja->tytul }}</td>
                                <!-- SZCEGÓŁY TRANSAKCJI-->
                                <td>
                                    <a class="btn btn-success butths" data-toggle="collapse" href="#collapse{{$key}}">
                                        SZCZEGÓŁY
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6">
                                    <div class="collapse" id="collapse{{$key}}">
                                        <div class="card card-body col-md-12" style="border:none">
                                            <div class="row">

                                                @if ($transakcja->isPrzelew())
                                                    <div class="col-md-4 danehist">
                                                        <p class="pelement">Dane płatnika</p>

                                                        <p class="inftexthist">Nr rachunku:
                                                            <span class="next">
                                                            {{ $transakcja->rachunek_platnika->nr_rachunku  }}
                                                        </span>
                                                        </p>

                                                        <p class="inftexthist">Imię i nazwisko:
                                                            <span class="next">
                                                            {{ $transakcja->rachunek_platnika->uzytkownik->pelneImie }}
                                                        </span>
                                                        </p>
                                                        <p class="inftexthist">Ulica, numer domu:
                                                            <span class="next">
                                                            {{ $transakcja->rachunek_platnika->klient->ulica_nr }}
                                                        </span>
                                                        </p>
                                                        <p class="inftexthist">Kod pocztowy:
                                                            <span class="next">
                                                            {{ $transakcja->rachunek_platnika->klient->kod_pocztowy }}
                                                        </span>
                                                        </p>
                                                        <p class="inftexthist">Miejscowość:
                                                            <span class="next">
                                                            {{ $transakcja->rachunek_platnika->klient->miasto }}
                                                        </span>
                                                        </p>

                                                    </div>

                                                    <div class="col-md-4 danehist">
                                                        <p class="pelement">Dane odbiorcy</p>


                                                        <p class="inftexthist">Nr rachunku:
                                                            <span class="next">
                                                            {{ $transakcja->rachunek_odbiorcy->nr_rachunku  }}
                                                        </span>
                                                        </p>

                                                        <p class="inftexthist">Imię i nazwisko:
                                                            <span class="next">
                                                            {{ $transakcja->rachunek_odbiorcy->uzytkownik->pelneImie }}
                                                        </span>
                                                        </p>
                                                        <p class="inftexthist">Ulica, numer domu:
                                                            <span class="next">
                                                            {{ $transakcja->rachunek_odbiorcy->klient->ulica_nr }}
                                                        </span>
                                                        </p>
                                                        <p class="inftexthist">Kod pocztowy:
                                                            <span class="next">
                                                            {{ $transakcja->rachunek_odbiorcy->klient->kod_pocztowy }}
                                                        </span>
                                                        </p>
                                                        <p class="inftexthist">Miejscowość:
                                                            <span class="next">
                                                            {{ $transakcja->rachunek_odbiorcy->klient->miasto }}
                                                        </span>
                                                        </p>
                                                    </div>
                                                @endif


                                                <div class="col-md-4 danehist">
                                                    <p class="pelement">Dane transakcji</p>

                                                    <p class="inftexthist">Tytuł:
                                                        <span class="next">
                                                            {{ $transakcja->tytul }}
                                                        </span>
                                                    </p>
                                                    <p class="inftexthist">Data transakcji:
                                                        <span class="next">
                                                            {{ $transakcja->data_wykonania }}
                                                        </span>
                                                    </p>
                                                    <p class="inftexthist">Kwota transakcji:
                                                        <span class="next">
                                                            {{ $transakcja->kwota }}
                                                        </span>
                                                    </p>
                                                    <p class="inftexthist">Saldo po transakcji:
                                                        <span class="next">
                                                            {{ $transakcja->saldo_po_transakcji }} zł
                                                        </span>
                                                    </p>
                                                    <p class="inftexthist">Numer transakcji:
                                                        <span class="next">
                                                            {{ $transakcja->id }}
                                                        </span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <!-- KONIEC SZCEGÓŁÓW TRANSAKCJI-->
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
@endsection
