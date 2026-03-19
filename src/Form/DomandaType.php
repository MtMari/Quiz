<?php

namespace App\Form;

use App\Entity\Argomento;
use App\Entity\Domanda;
use App\Repository\ArgomentoRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DomandaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('testo_domanda', TextareaType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'cols' => 35,
                    'rows' => 3,
                    'placeholder' => 'Testo Domanda'
                ],
                'translation_domain' => false
            ])
            ->add('argomento', EntityType::class, [
                'class' => Argomento::class,
                'label' => false,
                'choice_label' => 'nome_argomento',
                // 'query_builder' => fn(ArgomentoRepository $ar) => $ar->findAllOrderedByNome(),
                'query_builder' => function (ArgomentoRepository $ar): QueryBuilder {
                    return $ar->createQueryBuilder('a')
                        ->orderBy('a.nome_argomento', 'ASC');
                },
                'placeholder' => '-- Scegli un argomento --',
                'translation_domain' => false
            ])
            ->add('rispostas', CollectionType::class, [
                'entry_type' => RispostaType::class,
                'entry_options' => ['label' => false],
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'keep_as_list' => true,
                'label'=> false,
                'translation_domain' => false,
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
            'data_class' => Domanda::class,
        ]);
    }
}
