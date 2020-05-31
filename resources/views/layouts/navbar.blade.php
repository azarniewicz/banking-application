<header>
    <nav class="navbar navbar-dark bg-bank navbar-expand-lg">

        <a class="navbar-brand" href="{{url('/')}}">DEMO BANKU</a>

        <button class="navbar-toggler logo" type="button" data-toggle="collapse" data-target="#mainmenu" aria-controls="mainmenu" aria-expanded="false" aria-label="Przełącznik nawigacji">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainmenu">

            <ul class="navbar-nav mr-auto">

                <li class="nav-item active">
                    <a class="nav-link" href="/"><i class="fas fa-home"></i> Start </a>
                </li>

               <li class="nav-item">
                    <a class="nav-link" href="{{ url('przelew') }}"><i class="fas fa-coins"></i> Przelew </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ url('historia') }}"><i class="fas fa-list"></i> Historia </a>
                </li>

                <li class="nav-item dropdown">
                    <span class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="true" id="submenu" aria-haspopup="true"><i class="fas fa-layer-group"></i> Usługi </span>

                    <div class="dropdown-menu submenu">

                        <a class="dropdown-item" href="{{ url('staliodbiorcy') }}"> Stali odbiorcy </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ url('planowanetransakcje') }}"> Planowane transakcje </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item"  href="{{ url('kredyty') }}"> Kredyty </a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <span class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-expanded="false" id="submenu" aria-haspopup="true"><i class="far fa-user-circle"></i> Konto </span>

                    <div class="dropdown-menu submenu" aria-labelledby="submenu">

                        <a class="dropdown-item" href="{{ url('mojedane') }}"> Moje dane </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item"  href="{{ url('raty') }}"> Moje raty </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item"  href="{{ url('ustawienia') }}"> Ustawienia </a>
                        <div class="dropdown-divider"></div>
                        <form action="{{ url('wyloguj') }}" method="post">
                            @csrf
                            <button type="submit" name="your_name" style="margin:0;" value="your_value" class="dropdown-item">WYLOGUJ</button>
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>
