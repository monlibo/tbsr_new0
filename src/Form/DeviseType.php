<?php

namespace App\Form;

use App\Entity\Devise;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class DeviseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
               ->add('code')
               ->add('taux', NumberType::class, [
                'label' => 'Taux :',
                'required' => true,
                'invalid_message' => "Ce champ doit être un entier ou decimal",
                ])
               ->add('libelle')
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
            'data_class' => Devise::class,
        ]);
    }
}
