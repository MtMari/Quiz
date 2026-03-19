<?php

namespace App\Form;

use App\Entity\Risposta;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RispostaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('testo_risposta', TextareaType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'cols' => 45,
                    'rows' => 3,
                    'placeholder' => 'Testo Risposta'
                ],
                'translation_domain' => false
            ])
            ->add('punteggio', IntegerType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'placeholder' => 'Punteggio (0 - 1)'
                ],
                'translation_domain' => false
            ])
            // ->add('domanda', EntityType::class, [
            //     'class' => Domanda::class,
            //     'choice_label' => 'testo_domanda',
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Risposta::class,
        ]);
    }
}
