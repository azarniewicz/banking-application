<div class="alert alert-danger" id='alert_danger' role="alert">
    <ul class="a">
        @foreach($errors as $error)
          <li>{{$error}}</li>
        @endforeach
    </ul>

</div>
<style>
#alert_danger{
    font-size:12px
}

</style>
