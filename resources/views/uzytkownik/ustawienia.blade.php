@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="row">
            <section class="col-md-12 infobox">
                USTAWIENIA
                <ul class="nav nav-tabs navsset ">

                    <li class="nav-item">
                        <a class="nav-link active "
                           data-toggle="tab"
                           href="#ustawieniadanych"
                           role="tab"
                           aria-selected="true"
                        >USTAWIENIA DANYCH</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link "
                           data-toggle="tab"
                           href="#ustawieniaogolne"
                           aria-selected="false"
                        >USTAWIENIA OGÓLNE</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link "
                           data-toggle="tab"
                           href="#danelogowania"
                           aria-selected="false"
                        >ZMIANA DANYCH LOGOWANIA</a>
                    </li>

                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade active show"
                         id="ustawieniadanych"
                    >

                        <div class="col-md-12 przelew-form">

                            <div class="col-md-12"
                                 style="margin:0 auto;"
                            >
                                Dane klienta
                                <form action="{{ url('klient') }}"
                                      method="POST"
                                >
                                    @csrf
                                    <div class="form-group">
                                        <input type="text"
                                               name="nr_dowodu"
                                               class="form-control"
                                               placeholder="Zmień numer dowodu osobistego"
                                        />
                                    </div>
                                    <div class="form-group">
                                        <input type="text"
                                               name="nr_telefonu"
                                               class="form-control"
                                               placeholder="Zmień numer telefonu"
                                               value=""
                                        />
                                    </div>
                                    <div class="form-group">
                                        <input type="submit"
                                               class="btnContact"
                                               value="ZMIEŃ"
                                        />
                                    </div>
                                </form>
                                Zmień miejsce zamieszkania
                                <form action="{{ url('klient') }}"
                                      method="POST"
                                >
                                    @csrf
                                    <div class="form-group">
                                        <input type="text"
                                               name="miasto"
                                               class="form-control"
                                               placeholder="Miasto"
                                               value=""
                                        />
                                    </div>
                                    <div class="form-group">
                                        <input type="text"
                                               name="ulica_nr"
                                               class="form-control"
                                               placeholder="Ulica i numer domu"
                                               value=""
                                        />
                                    </div>
                                    <div class="form-group">
                                        <input type="text"
                                               name="kod_pocztowy"
                                               class="form-control"
                                               placeholder="Kod pocztowy"
                                               value=""
                                        />
                                    </div>

                                    <div class="form-group">
                                        <input type="submit"
                                               name="btnSubmit"
                                               class="btnContact"
                                               value="ZMIEŃ"
                                        />
                                    </div>
                                </form>
                            </div>
                        </div>
                        <span style="color:gray;margin-top:40px;font-size:12px;">W celu zmiany pozostałych danych należy skontaktować się z naszą infolinią lub odwiedzić osobiście siedzibę banku!</span>
                    </div>
                    <div class="tab-pane"
                         id="ustawieniaogolne"
                    >
                        <div class="col-md-12 przelew-form">

                            <div class="col-md-12"
                                 style="margin:0 auto;"
                            >
                                Limity
                                <form action="{{ url('klient') }}"
                                      method="POST"
                                >
                                    @csrf
                                    <div class="form-group">
                                        <input type="number"
                                               name="limit_dzienny"
                                               class="form-control"
                                               placeholder="Ustaw limit dzienny"
                                        />
                                    </div>
                                    <div class="form-group">
                                        <input type="number"
                                               name="ustawienie_budzetu"
                                               class="form-control"
                                               placeholder="Ustaw budżet miesięczny"
                                               value=""
                                        />
                                    </div>

                                    <div class="form-group">
                                        <input type="submit"
                                               class="btnContact"
                                               value="ZMIEŃ"
                                        />
                                    </div>

                                </form>
                                Karta Kredytowa
                                {{-- TODO po dodaniu karty --}}
                                <form>
                                    <div class="form-group">
                                        <input type="text"
                                               name="nowypinkarty"
                                               class="form-control"
                                               placeholder="Zmiana pinu karty"
                                               value=""
                                        />
                                    </div>
                                    <div class="form-group">
                                        <input type="submit"
                                               name="btnSubmit"
                                               class="btnContact"
                                               value="ZMIEŃ"
                                        />
                                    </div>
                                </form>
                            </div>
                        </div>
                        <span style="color:gray;margin-top:40px;font-size:12px;">Ustawienie maksymalnego limitu  dziennych oraz miesięcznych transakcji pozwoli Ci na lepsze zarządzanie pieniędzmi!</span>
                    </div>
                    <div class="tab-pane"
                         id="danelogowania"
                    >
                        <div class="col-md-12 przelew-form">

                            <div class="col-md-12"
                                 style="margin:0 auto;"
                            >
                                Dane Logowania
                                <form action="{{ url('klient\user') }}"
                                      method="POST"
                                >
                                    @csrf
                                    <div class="form-group">
                                        <input type="text"
                                               name="email"
                                               class="form-control"
                                               placeholder="Ustaw nowy email"
                                        />
                                    </div>
                                    <div class="form-group">
                                        <input type="password"
                                               name="pin"
                                               class="form-control"
                                               placeholder="Ustaw nowy PIN"
                                        />
                                    </div>
                                    <div class="form-group">
                                        <input type="password"
                                               name="password"
                                               class="form-control"
                                               placeholder="Ustaw nowe hasło"
                                               value=""
                                        />
                                    </div>

                                    <div class="form-group">
                                        <input type="submit"
                                               class="btnContact"
                                               value="ZMIEŃ"
                                        />
                                    </div>

                                </form>
                            </div>
                        </div>
                        <span style="color:gray;margin-top:40px;font-size:12px;">Pamiętaj, aby hasło posiadało minimum 8 znaków w tym: duże oraz małe litery, liczby i znaki specjalne!</span>
                        <br>
                        <span style="color:gray;margin-top:40px;font-size:12px;">PIN pomaga wzmocnić zabezpieczenie TWOJEGO KONTA!</span>
                    </div>
                </div>

            </section>
        </div>
    </div>

@endsection

