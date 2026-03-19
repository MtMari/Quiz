<?php

namespace App\Form;

use App\Entity\Argomento;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArgomentoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nome_argomento', TextType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'placeholder' => 'Nome Argomento'
                ],
                'translation_domain' => false
            ])
            ->add('descrizione', TextareaType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'cols' => 35,
                    'rows' => 3,
                    'placeholder' => 'Descrizione Argomento'
                ],
                'translation_domain' => false
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Conferma',
                'attr' => ['class' => 'btn-success bg-gradient'],
                'translation_domain' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Argomento::class,
        ]);
    }
}
