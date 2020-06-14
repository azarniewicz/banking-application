<?php

namespace App\Jobs;

use App\Rachunek;
use App\RachunekAggregateRoot;
use App\Transakcja;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class WykonajTransakcje implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var array
     */
    public $serialized;

    /**
     * Create a new job instance.
     *
     * @param  Transakcja  $transakcja
     */
    public function __construct(Transakcja $transakcja)
    {
        $this->serialized = $transakcja->jsonSerialize();
        $this->queue      = 'transakcje';
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $transakcja = new Transakcja($this->serialized);
        $nadawca    = Rachunek::numer($transakcja->nr_rachunku)->getAggregate();
        $odbiorca   = Rachunek::numer($transakcja->nr_rachunku_powiazanego)->getAggregate();

        DB::beginTransaction();
        try {
            $nadawca->przelewWychodzacy($transakcja)->persist();
            $odbiorca->przelewPrzychodzacy($transakcja)->persist();
        } catch (\Exception $e) {
            // W razie wystąpienia błędu, cofamy wszystkie zmiany,
            // oraz zwracamy uprzednio zablokowane środki na konto klienta
            DB::rollBack();
            $nadawca->fresh()
                    ->odblokujSrodki($transakcja->kwota, $e->getMessage())
                    ->persist();
        } finally {
            DB::commit();
        }
    }
}
