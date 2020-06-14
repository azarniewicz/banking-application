@extends('layouts.app')
@section('content')
    <div class="container row mx-auto">
        <div class="infobox przelew-form col-12 mx-auto">
            <h3>Wykonaj przelew</h3>
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <form action="{{ url('przelew')  }}"
                          method="POST"
                    >
                        @csrf
                        @include('uzytkownik.przelew-form')
                        <div class="form-group">
                            <select class="form-control"
                                    name="typ"
                            >
                                <option value="{{ \App\Transakcja::standard  }}">PRZELEW STANDARDOWY</option>
                                <option value="{{ \App\Transakcja::ekspres  }}">PRZELEW EKSPRESOWY</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="submit"
                                   name="btnSubmit"
                                   class="btnContact"
                                   value="Wykonaj przelew"
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
