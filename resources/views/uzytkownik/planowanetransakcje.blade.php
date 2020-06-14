@extends('layouts.app')
@section('content')
    <div class="container row mx-auto">
        <div class="infobox przelew-form col-12 mx-auto">
            <h3>ZAPLANUJ TRANSAKCJE</h3>
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <form action="{{ url('przelew')  }}"
                          method="POST"
                    >
                        @csrf
                        <input type="hidden"
                               name="typ"
                               value="{{ \App\Transakcja::planowana }}"
                               required
                        />

                        @include('uzytkownik.przelew-form')
                        <div class="form-group">
                            <input type="date"
                                   name="data_wykonania"
                                   class="form-control"
                                   placeholder="data"
                                   required
                            />
                        </div>
                        <div class="form-group">
                            <input type="submit"
                                   name="btnSubmit"
                                   class="btnContact"
                                   value="ZAPLANUJ"
                                   required
                            />
                        </div>
                    </form>
                </div>
                <div class="col-md-3">
                    @include('uzytkownik.lista-odbiorcow')
                </div>
            </div>
        </div>
    </div>

@endsection
