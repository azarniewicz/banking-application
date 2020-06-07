@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 infobox przelew-form">
                Wykonaj przelew
                <div class="col-md-8" style="margin:0 auto;">
                    <form action="{{ url('przelew')  }}" method="POST">
                        @csrf
                        <div class="form-group">
                            {{-- Ustawienie domyślnego rachunku tylko dla testów --}}
                            <input type="text" name="numer_rachunku" class="form-control" placeholder="Numer rachunku" value="{{ old('username') ?? \App\Rachunek::dostepneDoPrzelewow()->first()->nr_rachunku }}"/>
                        </div>
                        <div class="form-group">
                            <input type="text" name="kwota" class="form-control" placeholder="Kwota przelewu" value="{{ old('kwota')  }}"/>
                        </div>

                        <div class="form-group">
                            <textarea name="tytul" class="form-control" placeholder="Tytuł przelewu"
                                      style="width: 100%; height: 100px;">{{ old('tytul') }}</textarea>
                        </div>
                        <div class="form-group">
                            <textarea name="odbiorca" class="form-control" placeholder="Nazwa i adres odbiorcy"
                                      style="width: 100%; height: 100px;">{{ old('odbiorca') }}</textarea>
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="typ">
                                <option value="{{ \App\Transakcja::standard  }}">PRZELEW STANDARDOWY</option>
                                <option value="{{ \App\Transakcja::ekspres  }}">PRZELEW EKSPRESOWY</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="btnSubmit" class="btnContact" value="Wykonaj przelew"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
