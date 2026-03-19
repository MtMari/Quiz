<?php

namespace App\EventSubscriber;

use App\Event\Domanda\DeleteDomandaEvent;
use App\Event\Domanda\EditDomandaEvent;
use App\Event\Domanda\NewDomandaEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class DomandaLoggerSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private LoggerInterface $domandaLogger
    ){

    }

    public function onNewDomandaEvent($event): void
    {
        $this->domandaLogger->debug('Nuova domanda creata', [
            'id'        => $event->getDomanda()->getId(),
            'testo'     => $event->getDomanda()->getTestoDomanda(),
            'argomento_id' => $event->getDomanda()->getArgomento()->getId(),
            'rispostas' => $event->getDomanda()->getRispostas()
        ]);
    }

    public function onEditDomandaEvent($event): void
    {
        $this->domandaLogger->debug('Domanda con id:{id} modificata', [
            'id'        => $event->getDomanda()->getId(),
            'testo'     => $event->getDomanda()->getTestoDomanda(),
            'argomento_id' => $event->getDomanda()->getArgomento()->getId(),
            'rispostas' => $event->getDomanda()->getRispostas()
        ]);
    }

    public function onDeleteDomandaEvent($event): void
    {
        $this->domandaLogger->debug('Domanda con id:{id} eliminata', [
            'id'        => $event->getDomanda()->getId(),
            'testo'     => $event->getDomanda()->getTestoDomanda(),
            'argomento_id' => $event->getDomanda()->getArgomento()->getId(),
            'rispostas' => $event->getDomanda()->getRispostas()
        ]);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            NewDomandaEvent::class      => 'onNewDomandaEvent',
            EditDomandaEvent::class     => 'onEditDomandaEvent',
            DeleteDomandaEvent::class   => 'onDeleteDomandaEvent',
        ];
    }
}
