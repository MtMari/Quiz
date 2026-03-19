<?php

namespace App\Form;

use App\Entity\Utente;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'Username',
                'translation_domain' => false
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => ['placeholder' => 'esempio@email.com',],
                
                'translation_domain' => false
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'label' => 'Password',
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank(message: 'La password è obbligatoria'),
                    new Length(
                        min: 6,
                        minMessage: 'La password deve essere lunga almeno {{ limit }} caratteri',
                        max: 4096
                    )
                ],
                'translation_domain' => false
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'label' => 'Accetto i Termini e Condizioni',
                'attr' => ['class' => 'small-text'],
                'constraints' => [
                    new IsTrue([
                        'message' => 'Conferma per continuare.',
                    ]),
                ],
                'translation_domain' => false
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    "Utente Base" => "ROLE_USER",
                    "Utente Amministratore" => "ROLE_ADMIN"
                ],
                'label' => false,
                'translation_domain' => false,
            ])
        ;
        $builder->get('roles')
                ->addModelTransformer((new CallbackTransformer(
                    function ($rolesAsArray): string {
                        return count($rolesAsArray) ? $rolesAsArray[0] : null;
                    },
                    function ($rolesAsString): array {
                        return [$rolesAsString]; 
                    }
                )));
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utente::class,
        ]);
    }
}
