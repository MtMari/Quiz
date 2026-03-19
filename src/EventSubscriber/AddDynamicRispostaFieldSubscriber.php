<?php

namespace App\EventSubscriber;

use App\Repository\ArgomentoRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Event\PreSetDataEvent;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AddDynamicRispostaFieldSubscriber implements EventSubscriberInterface
{

    // public function __construct(
    //     private ArgomentoRepository $argomentoRepository
    // ){

    // }
    public function onFormPreSetData(PreSetDataEvent $event): void
    {
        $x = $event->getData();
        $form = $event->getForm();
        $array=['t1', 't2'];
        dump($x);

        if( !$x || null === $x->getId()){
            // $form->add('quiz', ChoiceType::class);
            foreach($array as $k){
                $form->add($k, ChoiceType::class,[
                    'choices' => ['a'=>'aval', 'b'=>'bval'],
                    'multiple' => true,
                    'expanded' => true
                ]);

            }
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'form.pre_set_data' => 'onFormPreSetData',
        ];
    }
}
