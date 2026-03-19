<?php

namespace App\Twig\Components;

use App\Repository\ArgomentoRepository;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
final class RicercaQuiz
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public string $query = '';

    // #[LiveProp(useSerializerForHydration:true)]
    public array $argomenti;


    public function __construct(
        private ArgomentoRepository $argomentoRepository
    ){

    }
    public function getArgomenti()
    {
        return $this->argomentoRepository->findArgomentoByQuery($this->query);
    }
}
