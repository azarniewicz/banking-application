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
                            JSON_EXTRACT(event_properties, "$.nrRachunkuDocelowego") as nr_rachunku_powiazanego, 
                            JSON_EXTRACT(event_properties, "$.kwota") as kwota,
                            JSON_EXTRACT(event_properties, "$.tytul") as tytul_przelewu,
                            stored_events.created_at as "data"
                        from stored_events 
                            inner join rachunki on aggregate_uuid = rachunki.uuid
                        WHERE JSON_EXTRACT(event_properties, "$.kwota") IS NOT NULL
                        UNION
                        SELECT 
                            JSON_EXTRACT(event_properties, "$.nrRachunkuDocelowego") as nr_rachunku, 
                            "Przelew przychodzacy" as typ,
                            nr_rachunku as nr_rachunku_powiazanego, 
                            JSON_EXTRACT(event_properties, "$.kwota") as kwota,
                            JSON_EXTRACT(event_properties, "$.tytul") as tytul_przelewu,
                            stored_events.created_at as "data"
                        from stored_events 
                            inner join rachunki on aggregate_uuid = rachunki.uuid
                        WHERE JSON_EXTRACT(event_properties, "$.kwota") IS NOT NULL and JSON_EXTRACT(event_properties, "$.nrRachunkuDocelowego") is not null'
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
