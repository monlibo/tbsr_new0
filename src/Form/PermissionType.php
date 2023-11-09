<?php

namespace App\Form;

use App\Entity\Permission;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PermissionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('permission')
            ->add('description')
            // ->remove('created')
            // ->remove('auteur')
            // ->remove('last_updated')
            // ->remove('last_updated_auteur')
            // ->remove('supprimer')
            // ->remove('supprimer_date')
            // ->remove('supprimer_auteur')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Permission::class,
        ]);
    }
}
