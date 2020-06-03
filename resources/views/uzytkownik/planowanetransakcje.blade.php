@extends('layouts.app')
@section('content')
        <div class="container">
            <div class="row">
                <div class="col-md-12 infobox przelew-form">
                   ZAPLANUJ TRANSAKCJE
            <form>
               <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" name="nrrachunku" class="form-control" placeholder="Numer rachunku"/>
                        </div>
                        <div class="form-group">
                            <input type="text" name="kwotaprzelewu" class="form-control" placeholder="Kwota przelewu" value="" />
                        </div>

                        <div class="form-group">
                            <textarea name="tytulprzelewu" class="form-control" placeholder="Tytuł przelewu" style="width: 100%; height: 100px;"></textarea>
                        </div>


                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <textarea name="txtMsg" class="form-control" placeholder="Nazwa i adres odbiorcy" style="width: 100%; height: 100px;"></textarea>
                        </div>
                        <div class="form-group">
                            <input type="date" name="data" class="form-control" placeholder="data"/>
                        </div>
                      <div class="form-group">
                            <input type="submit" name="btnSubmit" class="btnContact" value="ZAPLANUJ" />
                        </div>
                    </div>


                </div>
            </form>

                </div>
             </div>
        </div>

@endsection
