<?php

namespace App\Form;

use App\Entity\NiveauVisibilite;
use App\Entity\Projet;
use App\Entity\Rapport;
use App\Entity\Structure;
use App\Entity\TypeDonnee;
use App\Entity\TypeGraphe;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RapportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle')
            ->add('commentaire')
//            ->add('created')
//            ->add('auteur')
//            ->add('last_updated')
//            ->add('last_updated_auteur')
//            ->add('supprimer')
//            ->add('supprimer_date')
//            ->add('supprimer_auteur')
            ->add('structure',EntityType::class,[
                'class'=>Structure::class,
                'placeholder'=>'Selectionner une structure',
                'attr'=>[
                    'class'=>'form-control select_simple'
                ]
            ])
            ->add('typeDonnee',EntityType::class,[
                'class'=>TypeDonnee::class,
                'placeholder'=>'Selectionner une type de donnée',
                'attr'=>[
                    'class'=>'form-control select_simple'
                ]
            ])
            ->add('niveauVisibilite',EntityType::class,[
                'class'=>NiveauVisibilite::class,
                'placeholder'=>'Selectionner un niveau',
                'attr'=>[
                    'class'=>'form-control select_simple'
                ]
            ])
            ->add('typeGraphe',EntityType::class,[
                'class'=>TypeGraphe::class,
                'placeholder'=>'Selectionner un type de Graphe',
                'attr'=>[
                    'class'=>'form-control select_simple'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Rapport::class,
        ]);
    }
}
