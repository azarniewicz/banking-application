@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="row">
            <section class="col-md-12 infobox">
                USTAWIENIA
                <ul class="nav nav-tabs navsset ">

                    <li class="nav-item">
                        <a class="nav-link active"
                           data-toggle="tab"
                           href="#ustawieniaogolne"
                           aria-selected="false"
                        >USTAWIENIA OGÓLNE</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active"
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
                            </div>
                        </div>
                        <p style="color:gray;margin-top:40px;font-size:12px;">Ustawienie maksymalnego limitu  dziennych oraz miesięcznych transakcji pozwoli Ci na lepsze zarządzanie pieniędzmi!</span>
                        <p style="color:red;margin-top:40px;font-size:12px;">W celu zmiany innych danych skontaktuj się z administratorem.</span>

                    </div>
                </div>

            </section>
        </div>
    </div>

@endsection

