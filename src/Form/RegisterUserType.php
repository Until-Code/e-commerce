<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class RegisterUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => "Votre Adresse Email",
                'attr' => [
                    "placeholder" => "john@gmail.com"
                ]
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
                            "placeholder" => "Indiquez votre mot de passe"
                        ],
                        'label' => 'Votre mot de passe',
                        'hash_property_path' => 'password'
                    ],
                    'second_options' => [
                        'label' => 'Confirmez votre mot de passe'
                    ],
                    'mapped' => false,
                ])

            ->add('firstname', TextType::class, [

                'constraints' => [new Length([
                    'min' => 3,
                    'max' => 10,
                    'minMessage'=> 'Veuillez saisir au minmum 3 caractère !',
                    'maxMessage' => 'Veuillez saisir au maximum 10 caractères !'

                ])],
                'label' => "Prénom",
                'attr' => [
                    "placeholder" => "Indiquez votre Prénom"
                ]
            ])
            ->add('lastname', TextType::class, [

                'constraints' => [new Length([
                    'min' => 3,
                    'max' => 10,
                    'minMessage'=> 'Veuillez saisir au minmum 3 caractère !',
                    'maxMessage' => 'Veuillez saisir au maximum 10 caractères !'

                ])],
                'label' => "Nom",
                'attr' => [
                    "placeholder" => "indiquez votre nom"
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Valider",
                'attr' => [
                    "class" => "btn btn-success"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,

        ]);
    }
}

