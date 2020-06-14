<div class="form-group">
    <input id="numerRachunku"
           type="text"
           name="numer_rachunku"
           class="form-control"
           placeholder="Numer rachunku"
           value="{{ old('numer_rachunku') }}"
           required
    />
    <h6 id="nazwaBanku" class="text-sm-left p-1"></h6>
</div>

<div class="form-group">
    <input type="text"
           name="kwota"
           class="form-control"
           placeholder="Kwota przelewu"
           value="{{ old('kwota') }}"
           required
    />
</div>

<div class="form-group">
    <textarea name="tytul"
              class="form-control"
              placeholder="Tytuł przelewu"
              style="width: 100%; height: 100px;"
              required
    >{{ old('tytul') }}</textarea>
</div>

<div class="form-group">
    <textarea name="odbiorca"
              class="form-control"
              placeholder="Nazwa i adres odbiorcy"
              style="width: 100%; height: 100px;"
              required
    >{{ old('odbiorca') }}</textarea>
</div>


@push('scripts')
    <script lang="js">

        const numery_bankow = {
            1010 : 'Narodowy Bank Polski',
            1020 :' PKO BP',
            1030 : 'Bank Handlowy (Citi Handlowy)',
            1050 : 'ING',
            1060 : 'BPH',
            1090 : 'Santander Bank  Polska (daw. BZ WBK)',
            1130 : 'BGK',
            1140 : 'mBank, Orange Finanse',
            1160 : 'Bank Millennium',
            1240 : 'Pekao',
            1280 : 'HSBC',
            1320 : 'Bank Pocztowy',
            1470 : 'Eurobank',
            1540 : 'BOŚ Bank',
            1580 : 'Mercedes-Benz Bank Polska',
            1610 : 'SGB – Bank',
            1670 : 'RBS Bank (Polska)',
            1680 : 'Plus Bank',
            1750 : 'Raiffeisen Bank',
            1840 : 'Societe Generale',
            1870 : 'Nest Bank',
            1910 : 'Deutsche Bank Polska',
            1930 : 'Bank Polskiej Spółdzielczości',
            1940 : 'Credit Agricole Bank Polska',
            1950 : 'Idea Bank',
            2030 : 'BNP Paribas',
            2070 : 'FCE Bank Polska',
            2120 : 'Santander Consumer Bank',
            2130 : 'Volkswagen Bank',
            2140 : 'Fiat Bank Polska',
            2160 : 'Toyota Bank',
            2190 : 'DnB Nord',
            2480 : 'Getin Noble Bank',
            2490 : 'Alior Bank, T-Mobile Usługi Bankowe'
        };

        $('#numerRachunku').keyup(function () {
            const value = $(this).val().substring(0, 4);
            if(value.length > 3 && numery_bankow.hasOwnProperty(value)) {
                console.log($('#nazwaBanku'));
                $('#nazwaBanku').text(numery_bankow[value]);
            } else {
                $('#nazwaBanku').text('');
            }
        });
    </script>
@endpush
