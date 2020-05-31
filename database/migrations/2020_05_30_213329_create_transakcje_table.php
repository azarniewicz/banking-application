<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTransakcjeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::statement('CREATE VIEW transakcje AS
                       SELECT 
                            nr_rachunku, 
                            event_class as typ,
                            event_properties->>"$.nrRachunkuDocelowego" as nr_rachunku_powiazanego, 
                            event_properties->>"$.kwota" as kwota,
                            event_properties->>"$.tytul" as tytul,
                            meta_data->>"$.saldo_po_transakcji" as saldo_po_transakcji,
                            stored_events.created_at as "data"
                       from stored_events 
                            inner join rachunki on aggregate_uuid = rachunki.uuid
                       WHERE event_properties->>"$.kwota" IS NOT NULL
                       UNION
                       SELECT 
                            event_properties->>"$.nrRachunkuDocelowego" as nr_rachunku, 
                            "Przelew przychodzący" as typ,
                            nr_rachunku as nr_rachunku_powiazanego, 
                            event_properties->>"$.kwota" as kwota,
                            event_properties->>"$.tytul" as tytul_,
                            meta_data->>"$.saldo_rachunku_docelowego_po_transakcji" as saldo_po_transakcji,
                            stored_events.created_at as "data"
                       from stored_events 
                            inner join rachunki on aggregate_uuid = rachunki.uuid
                       WHERE event_properties->>"$.kwota" IS NOT NULL and event_properties->>"$.nrRachunkuDocelowego" is not null'
        );

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW transakcje');
    }
}
