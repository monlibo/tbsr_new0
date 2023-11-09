<?php

namespace App\Form;

use App\Entity\Activite;
use App\Entity\Devise;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActiviteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
//axe
            ->add('axe', EntityType::class,[
                'class'=>Activite::class,
                'placeholder'=>'Sélectionnez l\'axe',
                'choice_label' =>function(Activite $activite){
                    return $activite->getLibelleActivite();
                },
                'mapped' => false
            ])

            //Programme
            ->add('programme', EntityType::class,[
                'class'=>Activite::class,
                'placeholder'=>'Sélectionnez le programme',
                'choice_label' =>function(Activite $activite){
                    return $activite->getLibelleActivite();
                },
                'mapped' => false
            ])

            //Programme
            ->add('activite', EntityType::class,[
                'class'=>Activite::class,
                'placeholder'=>'Sélectionnez l\'action',
                'choice_label' =>function(Activite $activite){
                    return $activite->getLibelleActivite();
                },
            ])
            ->add('coutActivite')
            ->add('devise', EntityType::class, [
                'class'=>Devise::class,
                'placeholder'=>'Sélectionnez la devise',
                'choice_label' =>function(Devise $devise){
                    return $devise->getLibelle();
                },
            ])
            ->add('coutActiviteFcfa')
            ->add('poids')
            ->add('libelleIndicateurIndividuel')

            ->add('numActivite')
            ->add('libelleActivite')

            ->add('resultatAttendu')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Activite::class,
        ]);
    }
}
