@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 infobox przelew-form">
                ZAPLANUJ TRANSAKCJE
                <form action="{{ url('przelew')  }}"
                      method="POST"
                >
                    @csrf
                    <input type="hidden"
                           name="typ"
                           value="{{ \App\Transakcja::planowana }}"
                    />
                    <div class="row">
                        <div class="col-md-6 mx-auto">
                            @include('uzytkownik.przelew-form')
                            <div class="form-group">
                                <input type="date"
                                       name="data_wykonania"
                                       class="form-control"
                                       placeholder="data"
                                />
                            </div>
                            <div class="form-group">
                                <input type="submit"
                                       name="btnSubmit"
                                       class="btnContact"
                                       value="ZAPLANUJ"
                                />
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

@endsection
