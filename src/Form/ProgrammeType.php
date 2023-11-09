<?php

namespace App\Form;

use App\Entity\Activite;
use App\Entity\TypeActivite;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProgrammeType extends AbstractType
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
            ->add('activite', EntityType::class,[
                'class'=>Activite::class,
                'placeholder'=>'Sélectionnez l\'axe',
                'choice_label' =>function(Activite $activite){
                    return $activite->getLibelleActivite();
                },
            ])
            ->add('numActivite', )
            ->add('libelleActivite')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Activite::class,
        ]);
    }
}
