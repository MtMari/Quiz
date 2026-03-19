<?php

namespace App\Service;

use App\Repository\RispostaRepository;
use Symfony\Component\HttpFoundation\Request;

class RispostasByPost
{
    public function __construct(
        private RispostaRepository $rispostaRepository
    ){

    }

    public function rispostasByPost( array $datiPost ): array
    {
        $rispostas = [];
        
        foreach($datiPost as $key => $idRisposta )
        {
            $rispostas[] = $this->rispostaRepository->findOneBy(['id' => $idRisposta]);
        }

        return $rispostas;
    }
}