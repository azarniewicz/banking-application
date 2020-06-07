@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 infobox przelew-form">
                Wykonaj przelew
                <div class="col-md-6"
                     style="margin:0 auto;"
                >
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
            </div>
        </div>
    </div>
@endsection
