<?php

namespace App\Event\Argomento;

use App\Entity\Argomento;
use Symfony\Contracts\EventDispatcher\Event;

class DeleteArgomentoEvent extends Event
{
    public function __construct(
        private Argomento $argomento
    ){

    }

    public function getArgomento(): Argomento
    {
        return $this->argomento;
    }
}