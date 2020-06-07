@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 infobox">
                MOJE DANE

                <div class="dropdown-divider"></div>
                <p class="inftext">Email:
                    <span class="tresc">{{ $klient->uzytkownik->email  }}</span>
                </p>
                <div class="dropdown-divider"></div>
                <p class="inftext">Imię i nazwisko:
                    <span class="tresc">{{ $klient->uzytkownik->pelneImie  }}</span>
                </p>
                <div class="dropdown-divider"></div>
                <p class="inftext">PESEL:
                    <span class="tresc">{{ $klient->pesel  }}</span>
                </p>
                <div class="dropdown-divider"></div>
                <p class="inftext">Numer dowodu osobistego:
                    <span class="tresc">{{ $klient->nr_dowodu }}</span>
                </p>
                <div class="dropdown-divider"></div>
                <p class="inftext">Ulica i numer:
                    <span class="tresc">{{ $klient->ulica_nr }}</span>
                </p>
                <div class="dropdown-divider"></div>
                <p class="inftext">Kod pocztowy:
                    <span class="tresc">{{ $klient->kod_pocztowy  }}</span>
                </p>
                <div class="dropdown-divider"></div>
                <p class="inftext">Miasto:
                    <span class="tresc">{{ $klient->miasto }}</span>
                </p>
                <div class="dropdown-divider"></div>
                <p class="inftext">Numer telefonu:
                    <span class="tresc">{{ $klient->nr_telefonu }}</span>
                </p>
                <div class="dropdown-divider"></div>
                <p class="inftext">Limit dzienny:
                    <span class="tresc">{{ $klient->limit_dzienny }}</span>
                </p>
                <div class="dropdown-divider"></div>
                <p class="inftext">Budżet:
                    <span class="tresc">{{ $klient->ustawienie_budzetu }}</span>
                </p>
            </div>

        </div>
    </div>

@endsection
