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
    <form>
       <div class="row">
            <div class="col-md-8 mgg">
                <div class="form-group">
<input type="text" name="wlasnanazwa" class="form-control" placeholder="Nazwa własna odbiorcy"/>
                </div>
                <div class="form-group">
<input type="text" name="nrkonta" class="form-control" placeholder="Numer rachunku"/>
                </div>
                <div class="form-group">
<textarea name="nazwa" class="form-control" placeholder="Nazwa i adres przelewu" style="width: 100%; height: 100px;"></textarea>
                </div>
                <div class="form-group">
        <input type="submit" name="btnSubmit" class="btnContact" value="ZAPISZ" />
                </div>
            </div>
        </div>
    </form>
        </div>


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
                    <tr>
                      <th>Maliniakowa</th>
                      <td>00 000 00000 00000 00000 0000</td>
                      <td>Sklep Stasio</td>
                      <td>
                        <a class="btn btn-danger butths" data-toggle="collapse" href="usun">
                            USUŃ STAŁEGO ODBIORCE
                        </a>
                    </td>
                    </tr>
                    <tr>
                      <th>Alkoholik ugułem</th>
                      <td>00 000 00000 00000 00000 0000</td>
                      <td>Miłoszow Męczyk ul.Bożej ćwiartki 3/4</td>
                      <td>
                        <a class="btn btn-danger butths" data-toggle="collapse" href="usun">
                            USUŃ STAŁEGO ODBIORCE
                        </a>
                    </td>
                    </tr>
                  </tbody>
             </table>
        </div>
    </div>
</div>
@endsection
