<?php

namespace App\Form;

use App\Entity\Periode;
use App\Entity\TypeActivite;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TypeActiviteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle')
            ->add('annee')

            ->add('typtActivite', EntityType::class, [
                'class'=>TypeActivite::class,
                'placeholder'=> 'Sélectionnez le type activité parent',
                'choice_label' =>function(TypeActivite $typeActivite){
                return $typeActivite->getLibelle();
                },
                'required' => false,
            ])

            ->add('periode', EntityType::class, [
                'class'=>Periode::class,
                'placeholder'=> 'Sélectionnez la période',
                'choice_label' => function(Periode $periode){
                return $periode->getId();
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TypeActivite::class,
        ]);
    }
}
