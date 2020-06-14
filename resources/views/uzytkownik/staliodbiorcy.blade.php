@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">


    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12 infobox przelew-form">
           Dodaj stałego odbiorcę
           <form method="POST" action={{action('StalyOdbiorcaController@store')}}>
            @csrf
       <div class="row">
            <div class="col-md-8 mgg">
                <div class="form-group">
<input type="text" required name="nazwa" class="form-control" placeholder="Nazwa własna odbiorcy"/>
                </div>
                <div class="form-group">
<input type="text" required name="nr_rachunku" class="form-control" placeholder="Numer rachunku"/>
                </div>
                <div class="form-group">
<textarea required name="nazwa_adres" class="form-control" placeholder="Nazwa i adres przelewu" style="width: 100%; height: 100px;"></textarea>
                </div>
                <div class="form-group">
        <input type="submit" name="btnSubmit" class="btnContact" value="ZAPISZ" />
                </div>
            </div>
        </div>
    </form>
        </div>

        @if($staliOdbiorcy->count() > 0)

            <div class="col-md-12 infobox">
                Aktualni stali odbiorcy
                <table class="table">
                      <thead>
                        <tr>
                          <th scope="col">Twoja nazwa odbiorcy</th>
                          <th scope="col">NUMER RACHUNKU</th>
                          <th scope="col">NAZWA I ADRES</th>
                          <th scope="col"></th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($staliOdbiorcy as $stalyOdbiorca)
                        <tr>
                        <th>{{$stalyOdbiorca->nazwa}}</th>
                          <td>{{$stalyOdbiorca->nr_rachunku}}</td>
                          <td>{{$stalyOdbiorca->nazwa_adres}}</td>
                          <td>
                            <form method="POST" action={{url("staliodbiorcy/$stalyOdbiorca->id_odbiorcy")}}>
                                @csrf
                                {{ method_field('DELETE') }}
                                <button class="btn btn-danger butths" data-toggle="collapse" href="usun">
                                    USUŃ STAŁEGO ODBIORCE
                                </button>
                            </form>

                        </td>
                        </tr>
                        @endforeach
                      </tbody>
                 </table>
            </div>
        @endif
    </div>
</div>
@endsection
