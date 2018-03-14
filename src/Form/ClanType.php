<?php

namespace App\Form;

use App\Entity\Clan;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClanType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',
            TextType::class,
            [
                'label' => 'Nom du clan'
            ])
            ->add('description',
            TextareaType::class,
            [
                'label' => 'Description'
            ])
            /*->add('teams',
            ChoiceType::class,
            [
                'label'=> 'Teams du clan',
                //'class'=> Team::class,
                'choice_label'=>'name',
                'placeholder'=>'choisissez une team'
            ])*/    
            ->add('creation',
            DateType::class,
            [
                'label'=> 'Date de création'
            ])
            ->add('logo',
            FileType::class,
            [
                'label'=> 'Logo',
                'required'=> false
            ])
            
        ;
        // $options['data'] = l'entité Clan
        if(!is_null($options['data']->getLogo())){
            $builder->add(
                'remove_logo',
                CheckboxType::class,
                [
                    'label' => "Supprimer le logo",
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
            // uncomment if you want to bind to a class
            'data_class' => Clan::class,
        ]);
    }
}
