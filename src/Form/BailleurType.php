<?php

namespace App\Form;

use App\Entity\Bailleur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BailleurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle')
            ->add('description')
//            ->remove('created')
//            ->remove('createdBy')
//            ->remove('updatedAt')
//            ->remove('updatedBy')
//            ->remove('deletedAt')
//            ->remove('deletedBy')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Bailleur::class,
        ]);
    }
}
