<?php

namespace App\Form;

use App\Entity\Periode;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PeriodeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateDebut',DateType::class)
            ->add('dateFin',DateType::class)
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
            'data_class' => Periode::class,
        ]);
    }
}
