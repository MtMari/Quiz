<?php

namespace App\Twig\Components;

use App\Repository\ArgomentoRepository;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
final class TabellaConRicerca
{
    use DefaultActionTrait;

    // proprietà query
    #[LiveProp(writable: true)]
    public string $query = '';

    // altre eventuali proprietà (passaggio dei dati)
    #[LiveProp(useSerializerForHydration: true, serializationContext:[])]
    public array $dati;

    // costruttore x DI
    public function __construct(
        private ArgomentoRepository $argomentoRepository
    ){

    }

    // funzioni getDati con findByQuery da costruire dalla repo
    public function getDato()
    {
        return $this->argomentoRepository->findByQuery( $this->query );
    }

}
