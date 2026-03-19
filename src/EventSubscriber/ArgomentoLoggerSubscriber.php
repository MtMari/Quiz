<?php

namespace App\EventSubscriber;

use App\Event\Argomento\DeleteArgomentoEvent;
use App\Event\Argomento\EditArgomentoEvent;
use App\Event\Argomento\NewArgomentoEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ArgomentoLoggerSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private LoggerInterface $argomentoLogger
    ) {

    }

    public function onNewArgomentoEvent(NewArgomentoEvent $event): void
    {
        $this->argomentoLogger->debug('Nuovo argomento creato', [
            'id'                => $event->getArgomento()->getId(),
            'nome_argomento'    => $event->getArgomento()->getNomeArgomento(),
            'descrizione'       => $event->getArgomento()->getDescrizione(),
        ]);    
    }

    public function onEditArgomentoEvent(EditArgomentoEvent $event): void
    {
        $this->argomentoLogger->debug('Argomento con id:{id} modificato', [
            'id'                => $event->getArgomento()->getId(),
            'nome_argomento'    => $event->getArgomento()->getNomeArgomento(),
            'descrizione'       => $event->getArgomento()->getDescrizione(),
        ]);    
    }

    public function onDeleteArgomentoEvent(DeleteArgomentoEvent $event): void
    {
        $this->argomentoLogger->debug('Argomento con id:{id} eliminato', [
            'id'                => $event->getArgomento()->getId(),
            'nome_argomento'    => $event->getArgomento()->getNomeArgomento(),
            'descrizione'       => $event->getArgomento()->getDescrizione(),
        ]); 
    }

    public static function getSubscribedEvents(): array
    {
        return [
            NewArgomentoEvent::class    => 'onNewArgomentoEvent',
            EditArgomentoEvent::class   => 'onEditArgomentoEvent',
            DeleteArgomentoEvent::class => 'onDeleteArgomentoEvent',
        ];
    }
}