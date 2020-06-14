<h6><b>Stali odbiorcy</b></h6>
<div class="list-group lista-odbiorcow text-left">
    @foreach(auth()->user()->klient->stali_odbiorcy as $id => $stalyOdbiorca)
        <div class="odbiorca">
            <div class="list-group-item list-group-item-action"
                 id="stalyodbiorca"
            >
                <div class="justify-content-between">
                    <h6 class="mb-1"><b>{{ $stalyOdbiorca->nazwa }}</b></h6>
                </div>
                <p class="mb-1"
                   id="nazwa_adres"
                >{{ $stalyOdbiorca->nazwa_adres }}</p>
                <small id="rachunek">{{ $stalyOdbiorca->nr_rachunku }}</small>
            </div>
        </div>
    @endforeach
</div>



@push('scripts')
    <script lang="js">
        $(document).ready(function() {
            $('.odbiorca').click((e) => {
                $('.odbiorca div').removeClass('active');

                const odbiorca = $(e.target).closest('#stalyodbiorca');
                odbiorca.addClass('active');
                const nazwa_adres = odbiorca.find('#nazwa_adres').first().text();
                const rachunek = odbiorca.find('#rachunek').first().text();
                $("textarea[name='odbiorca']").html(nazwa_adres);
                $("input[name='numer_rachunku']").val(rachunek);
                $('#numerRachunku').keyup();
            });
        });

    </script>
@endpush
