<?php

namespace App\Form;

use App\Entity\Agent;
use App\Entity\Fonction;
use App\Entity\Structure;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AgentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->remove('NPI')
            ->remove('IFU')
            ->add('matricule')
            ->add('nom')
            ->add('prenom')
            ->add('email')
            ->add('telephone')
            ->add('nomdejeunefille')
            ->add('sexe')
            ->add('date_naissance')
            ->add('lieu_naissance')
//            ->remove('fullname')
//            ->remove('created')
//            ->remove('auteur')
//            ->remove('last_updated')
//            ->remove('last_updated_auteur')
//            ->remove('supprimer')
//            ->remove('supprimer_date')
//            ->remove('supprimer_auteur')
//            ->remove('utilisateur')
            ->add('structure', EntityType::class,[
                'class'=> Structure::class,
                'placeholder'=> 'Sélectionnez une structure',
                'choice_label'=>function(Structure $structure){
                return $structure->getCode().' -- '.  $structure->getLibelle();
                }
            ])

            ->add('fonction'
                , EntityType::class, [
                    'class'=> Fonction::class,
                    'placeholder'=> 'Sélectionnez une fonction',
                    'choice_label'=>function(Fonction $fonction){
                        return $fonction->getCode().' -- '.  $fonction->getLibelle();
                    }
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Agent::class,
        ]);
    }
}
