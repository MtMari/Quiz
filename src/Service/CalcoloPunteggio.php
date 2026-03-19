<?php

namespace App\Service;

class CalcoloPunteggio
{
    public function calcoloPunteggio( array $rispostasByPost ): int
    {
        $punteggioFinale = 0;

        foreach($rispostasByPost as $key => $risposta)
        {
            // refactorinig: modifica direttamente l'inserimento del punteggio a db
            if($risposta->getPunteggio() == 0){
                $punteggioFinale += -1;
            }else{
                $punteggioFinale += 1;
            }
        }
        
        return $punteggioFinale < 0 ? 0 : $punteggioFinale;
    }
}