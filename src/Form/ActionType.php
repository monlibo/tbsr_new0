<?php

namespace App\Form;

use App\Entity\Activite;
use App\Entity\Annee;
use App\Entity\Bailleur;
use App\Entity\Reforme;
use App\Entity\Structure;
use App\Entity\TypeActivite;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('typeActivite', EntityType::class, [
                'class'=>TypeActivite::class,
                'placeholder'=> 'Sélectionnez le type activité ',
                'choice_label' =>function(TypeActivite $typeActivite){
                    return $typeActivite->getLibelle();
                },
            ])
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
            ->add('activite', EntityType::class,[
                'class'=>Activite::class,
                'placeholder'=>'Sélectionnez l\'axe',
                'choice_label' =>function(Activite $activite){
                    return $activite->getLibelleActivite();
                },

            ])

            //structure responsable
            ->add('structureAssocie', EntityType::class, [
                'class'=>Structure::class,
                'placeholder'=>'Sélectionnez les structures associées',
                'choice_label' =>function(Structure $structure){
                    return $structure->getLibelle();
                },
                'mapped' => false
            ])

            //structure associée
            ->add('structure', EntityType::class, [
                'class'=>Structure::class,
                'placeholder'=>'Sélectionnez la structure responsable',
                'choice_label' =>function(Structure $structure){
                    return $structure->getLibelle();
                },
            ])

            //reformes
            ->add('reforme', EntityType::class, [
                'class'=>Reforme::class,
                'placeholder'=>'Sélectionnez les reformes',
                'choice_label' =>function(Reforme $reforme){
                    return $reforme->getLibelle();
                },
                'mapped' => false
            ])

            //bailleur
            ->add('bailleur', EntityType::class, [
                'class'=>Bailleur::class,
                'placeholder'=>'Sélectionnez les bailleur',
                'choice_label' =>function(Bailleur $bailleur){
                    return $bailleur->getLibelle();
                },
                'mapped' => false
            ])

            //
            ->add('anneeDebut', EntityType::class, [
                'class'=>Annee::class,
                'placeholder'=>'Sélectionnez l\'année début ',
                'choice_label' =>function(Annee $annee){
                    return $annee->getLibelle(). ' ' . $annee->getValeur();
                },
            ])

            //
            ->add('anneeFin', EntityType::class, [
                'class'=>Annee::class,
                'placeholder'=>'Sélectionnez l\'année de fin ',
                'choice_label' =>function(Annee $annee){
                    return $annee->getLibelle(). ' ' . $annee->getValeur();
                },
            ])



            ->add('numActivite')
            ->add('libelleActivite')
            ->add('libelleIntComp')
            ->add('objectifPrincipal')
            ->add('objectifSpecifique')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Activite::class,
        ]);
    }
}
