<?php

namespace App\Service;

use App\Repository\ArgomentoRepository;
use App\Repository\DomandaRepository;

class CalcoloPuntiTotali
{

    public function __construct(
        private ArgomentoRepository $argomentoRepository,
        private DomandaRepository $domandaRepository
    ){

    }
    public function calcoloPuntiTotali( string $messyNomeArgomento ): int
    {
        $punteggioTotale= 0;

        $nomeArgomento = str_replace('-', ' ', $messyNomeArgomento);
        $domande = $this->argomentoRepository->findOneBy(['nome_argomento' => $nomeArgomento])->getDomandas();
        
        foreach($domande as $domanda)
        {
            $punteggioTotale += count($this->domandaRepository->getRispostasCorrette($domanda->getId()));
        }

        return $punteggioTotale;
    }
}