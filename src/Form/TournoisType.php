<?php

namespace App\Form;

use App\Entity\Tournois;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TournoisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('jeu',
            TextType::class,
                    [
                'label' => 'Jeu'
                    ])
            ->add('date',
            DateTimeType::class,
                    [
                'label' => 'Date et heure'
                    ])
            ->add('nb_participant_max',
            IntegerType::class,
                    [
                'label' => 'Nombre de participant maximum'
                    ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            
            'data_class' => Tournois::class,
        ]);
    }
}
