@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 infobox przelew-form">
           Kredyty
        <h6>Oprocentowanie: {{$aktualneOprocentowanie * 100}}%</h6>
        <form action="{{action('KredytController@setWniosek')}}" method="POST">
       <div class="row">
                @csrf
            <div class="col-md-6 mgg">

                <div class="form-group">
<input required type="number" min="0" id="kwotaKredytu" onkeyup="getKwotaDoOddania()" name="kwota_kredytu" class="form-control" placeholder="Kwota kredytu" value=""/>
                </div>

                                    <div class="form-group">
                <select onchange="getKwotaDoOddania()" class="form-control" name="ilosc_rat" id="typprzelewu" value="3">
                  <option value="3">3 raty</option>
                  <option value="6">6 rat</option>
                  <option value="10">10 rat</option>
                  <option value="12">12 rat</option>
                  <option value="18">18 rat</option>
                  <option value="24">24 raty</option>
                  <option value="36">36 rat</option>
                </select>
              </div>

              <div class="form-group">
                <label for="kwotaDoOddania" style="font-size:12px;">Kwota do oddania</label>
                <input  type="text" id="kwotaDoOddania" class="form-control" readonly value=""/>
               </div>
               <div class="form-group">
                <label for="rataKredytu" style="font-size:12px;">Rata kredytu</label>
                <input  type="text" id="rataKredytu" class="form-control" readonly value=""/>
               </div>

                <div class="form-group">
                <input type="submit" name="btnSubmit" class="btnContact" value="WYŚLIJ" />
                </div>
            </div>
        </div>
    </form>
</div>
</div>
</div>
    <div class="container">
            <div class="row">
        <div class="col-md-12 infobox" style="padding-bottom:20px;">
                HISTORIA SKŁADANYCH WNIOSKÓW O KREDYT
                <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">DATA ZŁOŻENIA WNIOSKU</th>
                                    <th scope="col">DATA WERYFIKACJI</th>
                                    <th scope="col">KWOTA</th>
                                    <th scope="col">STATUS WNIOSKU</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($historiaSkladanychWnioskow as $wniosek)
                                <tr>
                                    <td>{{$wniosek->data_wniosku}}</td>
                                    <td>{{$wniosek->data_zakonczenia_wniosku}}</td>
                                    <td>{{$wniosek->kwota_kredytu}}</td>
                                    <td>{{$wniosek->zgoda_odmowa}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                 </table>
        </div>
    </div>
</div>
<script>
    function getKwotaDoOddania(){
        let kredyt = new Kredyty();
        kredyt.getKwotaDoOddania();
    }
    class Kredyty{
        get aktualneOprocentowanie() {
            return {{$aktualneOprocentowanie}}
        }
        get kwotaKredytu(){
            return parseFloat($("#kwotaKredytu").val());
            }
        get iloscRat(){
            return parseFloat($("#typprzelewu").val());
        }

        getKwotaDoOddania(){
            if(!isNaN(this.kwotaKredytu)){
                let wynik = this.countKredyt();
                $("#kwotaDoOddania").val((wynik * this.iloscRat).toFixed(2));
                $("#rataKredytu").val(wynik);
            }else{
                $("#kwotaDoOddania").val("");
                $("#rataKredytu").val("");
            }
        }
        countKredyt(){
            let kwotaKredytu = this.kwotaKredytu;
            let iloscRat = this.iloscRat;
            let rata = iloscRat;
            if(iloscRat > 12){
                rata = 12;
            }

            let wynikDolny = 0;

            for(let i = 1; i <= iloscRat; i ++){
                wynikDolny = wynikDolny + (1 / Math.pow((1 + (this.aktualneOprocentowanie / 12)),i))
            }

            return (kwotaKredytu / wynikDolny).toFixed(2);
        }
    }
</script>
@endsection
