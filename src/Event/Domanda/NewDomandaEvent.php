<?php

namespace App\Event\Domanda;

use App\Entity\Domanda;
use Symfony\Contracts\EventDispatcher\Event;

class NewDomandaEvent extends Event
{
    public function __construct(
        private Domanda $domanda
    ){

    }

    public function getDomanda(): Domanda
    {
        return $this->domanda;
    }
}