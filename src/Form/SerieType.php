<?php

namespace App\Form;

use App\Entity\Serie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SerieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('overview', TextareaType::class, [
                'label' => "Description",
                "required" => false,
            ])
            ->add('status', ChoiceType::class, [
                'expanded' => false,
                'multiple' => false,
                'choices' => [
                    'RETURNING' => 'returning',
                    'ENDED' => 'ended',
                    'CANCELED' => 'canceled',
                ]
            ])
            ->add('vote', IntegerType::class, [
                'attr' => [
                    'min' => 0.0,
                    'max' => 10.0,
                    'step' => 0.1
                ]
            ])
            ->add('popularity')
            ->add('genres', ChoiceType::class, [
                'multiple' => true,
                'choices' => [
                    'DRAMA' => 'drama',
                    'SF' => 'sf',
                    'COMEDY' => 'comedy',
                    'HORROR' => 'horror'
                ]
            ])
            ->add('firstAirDate', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('lastAirDate', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('backdrop')
            ->add('poster')
            ->add('tmdbId')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Serie::class,
        ]);
    }
}
