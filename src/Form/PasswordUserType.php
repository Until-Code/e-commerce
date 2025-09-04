<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class PasswordUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('actualPassword', PasswordType::class,
            [
                'label' => "Votre mot de passe actuel",
                'attr' => [
                    "placeholder" => "Indiquez votre mot nouveau de passe actuel"
                ],
                'mapped' => false

            ])
            ->add('plainPassword', RepeatedType::class,
                [
                    'type' => PasswordType::class,
                    'constraints' => [new Length([
                        'min' => 3,
                        'max' => 10,
                        'minMessage'=> 'Veuillez saisir au minmum 3 caractère !',
                        'maxMessage' => 'Veuillez saisir au maximum 10 caractères !'

                    ])],
                    'first_options'  => [
                        'attr' => [
                            "placeholder" => "Indiquez votre mot nouveau de passe"
                        ],
                        'label' => 'Votre nouveau mot de passe',
                        'hash_property_path' => 'password'
                    ],
                    'second_options' => [
                        'label' => 'Confirmez votre nouveau mot de passe'
                    ],
                    'mapped' => false,
                ])

            ->add('submit', SubmitType::class, [
                'label' => "Mettre à jour",
                'attr' => [
                    "class" => "btn btn-success"
                ]
            ])

            ->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {

                $form = $event->getForm();
                $user = $form->getConfig()->getOptions()['data'];
                $passwordHasher = $form->getConfig()->getOptions()['passwordHasher'];

               $isValid = $passwordHasher-> isPasswordValid(
                    $user,
                   $form->get('actualPassword')->getData()
                );

               if (!$isValid)

               {
                   $form->get('actualPassword')->addError(new FormError("Mauvais mot de passe actuel saisi"));

               }


                //get password from form

             /*   $actualPwd = $form->get('ActualPassword')->getData();

                // get actual password from database

                $actualPwdDatabase = $user->getPassword(); */



            })


        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'passwordHasher' => null
        ]);
    }
}
