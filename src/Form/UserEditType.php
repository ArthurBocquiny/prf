<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastname',
            TextType::class,
            [
                'label' => 'Prénom'
            ]
            )
            ->add('firstname',
            TextType::class,
            [
                'label' => 'Nom'
            ]
            )
            ->add('pseudo',
            TextType::class,
            [
                'label' => 'Pseudo'
            ]
            )
            
            ->add('country',
            CountryType::class,
            [
                'label' => 'Pays'
            ] 
            )
            ->add('birthdate',
            BirthdayType::class,
            array(
                'label' => 'Date de naissance',
                'format' => 'dd-MM-yyyy'
            )        
            )
            ->add('email',
            EmailType::class,
            [
                'label' => 'Email'
            ]
            )
            ->add('plainPassword',
            RepeatedType::class,
                [
                    // ... de type password
                    'type' => PasswordType::class,
                    'first_options' => [
                        'label' => 'Mot de passe'
                    ],
                    'second_options' => [
                        'label' => 'Confirmation du mot de passe'
                    ]
                ]
            )
            ->add('photo',
                // input type file
                FileType::class,
                [
                    'label' => 'Photo',
                    'required' => false
                ]
            )
        ;
        if(!is_null($options['data']->getPhoto())){
            $builder->add(
            'remove_photo',
            CheckboxType::class,
            [
                'label' => "Supprimer la photo",
                'required' => false,
                // champ non relié à un attribut de l'entité Article
                'mapped' => false
            ]
            );
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
           'data_class' => User::class,
        ]);
    }
}
