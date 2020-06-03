@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 infobox przelew-form">
           Kredyty

            <form>
       <div class="row">

            <div class="col-md-6 mgg">

                <div class="form-group">
<input type="text" name="name" class="form-control" placeholder="Imię" value="Jan"/>
                </div>

                <div class="form-group">
<input type="text" name="surname" class="form-control" placeholder="Nazwisko" value="Kowalski"/>
                </div>

                <div class="form-group">
<input type="text" name="pesel" class="form-control" placeholder="Pesel" value="00000000"/>
                </div>
                <div class="form-group">
<input type="text" name="nrdowodu" class="form-control" placeholder="Seria i numer dowodu" value="AGF 000000"/>
                </div>

                <div class="form-group">
<input type="text" name="nrtel" class="form-control" placeholder="Numer telefonu" value="555 555 555"/>
                </div>

                <div class="form-group">
<input type="text" name="city" class="form-control" placeholder="Miasto" value="Jelenia Góra"/>
                </div>

                <div class="form-group">
<input type="text" name="street" class="form-control" placeholder="Ulica i numer domu" value="Babia 6"/>
                </div>

                <div class="form-group">
<input type="text" name="postalcode" class="form-control" placeholder="Kod pocztowy" value="44-333"/>
                </div>

                <div class="form-group">
<input type="text" name="kwota" class="form-control" placeholder="Kwota kredytu" value=""/>
                </div>

                                    <div class="form-group">
                <select class="form-control" id="typprzelewu">
                  <option>3 raty</option>
                  <option>6 rat</option>
                  <option>10 rat</option>
                  <option>12 rat</option>
                  <option>18 rat</option>
                  <option>24 raty</option>
                  <option>36 rat</option>
                </select>
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
                                <tr>
                                    <td>22/05/2020</td>
                                    <td>29/05/2020</td>
                                    <td>5000zł</td>
                                    <td>ODRZUCONO</td>
                                </tr>
                                <tr>
                                    <td>22/05/2020</td>
                                    <td>29/05/2020</td>
                                    <td>5000zł</td>
                                    <td>ODRZUCONO</td>
                                </tr>
                            </tbody>
                 </table>
        </div>
    </div>
</div>
@endsection
