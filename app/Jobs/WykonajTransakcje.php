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
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $transakcja = new Transakcja($this->serialized);
        $nadawca    = RachunekAggregateRoot::retrieve($transakcja->id_rachunku);
        $odbiorca   = Rachunek::numer($transakcja->nr_rachunku_powiazanego)->getAggregate();

        DB::beginTransaction();
        try {
            $nadawca->przelewWychodzacy($transakcja)->persist();
            $odbiorca->przelewPrzychodzacy($transakcja)->persist();
        } catch (\Exception $e) {
            DB::rollBack();
            $nadawca->fresh()
                    ->odblokujSrodki($transakcja->kwota, $e->getMessage())
                    ->persist();
        } finally {
            DB::commit();
        }
    }
}
