@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4 boxraty">
          <p class="inftext">Pozostała kwota:  <span class="tresc">3500zł</span></p>
        </div>
        <div class="col-md-4 boxraty">
          <p class="inftext">Pozostało rat:  <span class="tresc">10</span></p>
        </div>

    </div>
</div>
    <div class="container">
        <div class="row">
            <div class="col-md-12 infobox">
                Aktualna rata
                <table class="table">
                      <thead>
                        <tr>
                          <th scope="col">KWOTA DO ZAPŁATY</th>
                          <th scope="col">TERMIN</th>
                          <th scope="col">SUMA ODSETEK RAT</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>530zł</td>
                          <td>01/05/2020</td>
                          <td>30ZŁ</td>
                        </tr>
                      </tbody>
                 </table>
            </div>
            <div class="col-md-12 infobox">
                Poprzednie raty
                <table class="table">
                      <thead>
                        <tr>
                          <th scope="col">KWOTA</th>
                          <th scope="col">TERMIN PŁATNOŚCI</th>
                          <th scope="col">KIEDY OPŁACONE</th>
                          <th scope="col">ODSETKI</th>
                        </tr>
                        <tr>
                          <td>250zł</td>
                          <td>01/04/2020</td>
                          <td></td>
                          <td>30ZŁ</td>
                        </tr>
                        <tr>
                          <td>250zł</td>
                          <td>01/03/2020</td>
                          <td>23/03/2020</td>
                          <td>0zł</td>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                 </table>
            </div>
         </div>
    </div>
@endsection
