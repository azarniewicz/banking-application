@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4 boxraty">
          <p class="inftext">Pozostała kwota:  <span class="tresc">{{$pozostalaKwota}}</span></p>
        </div>
        <div class="col-md-4 boxraty">
          <p class="inftext">Pozostało rat:  <span class="tresc">{{$pozostaloRat}}</span></p>
        </div>

    </div>
</div>
    <div class="container">
        <div class="row">
            <div class="col-md-12 infobox">
                Aktualna rata
                @if($aktualnaRata !== null)
                <table class="table">
                      <thead>
                        <tr>
                          <th scope="col">KWOTA DO ZAPŁATY</th>
                          <th scope="col">TERMIN</th>
                          <th scope="col">#</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                        <td>{{$aktualnaRata->cena}}</td>
                          <td>{{$aktualnaRata->termin_zaplaty}}</td>
                          <form action="{{action('RataController@zaplac',['id'=>$aktualnaRata->id_raty])}}" method="POST">
                            @csrf
                            <th><button class="btn btn-primary xs">Zapłać</button></th>
                          </form>

                        </tr>
                      </tbody>
                 </table>
                 @else
                 <h6>Brak aktualnych rat</h6>
                 @endif

            </div>
            <div class="col-md-12 infobox">
                Poprzednie raty

                <table class="table">
                      <thead>
                        <tr>
                          <th scope="col">KWOTA</th>
                          <th scope="col">TERMIN PŁATNOŚCI</th>
                          <th scope="col">KIEDY OPŁACONE</th>
                        </tr>
                        @foreach($poprzednieRaty as $rata)
                        <tr>
                          <td>{{$rata->cena}}</td>
                          <td>{{$rata->termin_zaplaty}}</td>
                          <td>{{$rata->data_wykonania}}</td>
                        </tr>
                        @endforeach
                      </thead>
                      <tbody>
                      </tbody>
                 </table>

            </div>
         </div>
    </div>
@endsection
