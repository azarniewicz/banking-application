<?php


namespace App\Events;

use Illuminate\Support\Carbon;
use Spatie\EventSourcing\Facades\Projectionist;
use Spatie\EventSourcing\ShouldBeStored;

abstract class WykonanieTransakcji implements ShouldBeStored
{
    /**
     * @var float
     */
    public $kwota;

    /**
     * Ta zmienna służy do trackowania dziennych i miesięcznych wydatków w agregacie rachunku.
     *
     * @var Carbon
     */
    public $createdAt;

    /**
     * Create a new event instance.
     *
     * @param  float  $kwota
     */
    public function __construct(float $kwota)
    {
        $this->kwota = $kwota;
        $this->createdAt = now();
    }

    /**
     * @return Carbon
     */
    public function getCreatedAt(): Carbon
    {
        return Carbon::parse($this->createdAt);
    }
}
