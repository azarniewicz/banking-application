@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 infobox przelew-form">
           Wykonaj przelew
                             <div class="col-md-8" style="margin:0 auto;">
    <form>
                <div class="form-group">
                    <input type="text" name="nrrachunku" class="form-control" placeholder="Numer rachunku"/>
                </div>
                <div class="form-group">
                    <input type="text" name="kwotaprzelewu" class="form-control" placeholder="Kwota przelewu" value="" />
                </div>

                <div class="form-group">
                    <textarea name="tytulprzelewu" class="form-control" placeholder="Tytuł przelewu" style="width: 100%; height: 100px;"></textarea>
                </div>
                                        <div class="form-group">
                    <textarea name="txtMsg" class="form-control" placeholder="Nazwa i adres odbiorcy" style="width: 100%; height: 100px;"></textarea>
                </div>
                <div class="form-group">
                <select class="form-control" id="typprzelewu">
                  <option>PRZELEW STANDARDOWY</option>
                  <option>PRZELEW EKSPRESOWY</option>
                </select>
              </div>
                <div class="form-group">
                    <input type="submit" name="btnSubmit" class="btnContact" value="Wykonaj przelew" />
                </div>
    </form>
            </div>
        </div>
     </div>
</div>
@endsection
