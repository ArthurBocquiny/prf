<?php

namespace App\Form;

use App\Entity\Tournois;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TournoisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                
            ->add('jeu',
            HiddenType::class,
                    [
                        'data'  => $_GET['game_name']
                    ])
                
            ->add('categorie',
            ChoiceType::class, array(
                'choices' => array(
                'Speed run' => 'speedrun',
                'FPS' => 'FPS',
                'Clan' => 'Clan',
                )
            ),
                    [
                'label' => 'Catégorie'
                    ])
                
            ->add('description',
            TextareaType::class,
                    [
                'label' => 'Description'
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
                
            ->add('nb_participant_actuel',
            HiddenType::class,
                    [
                'data' => 0
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
