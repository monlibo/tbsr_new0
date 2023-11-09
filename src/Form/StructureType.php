<?php

namespace App\Form;

use App\Entity\Structure;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StructureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code',TextType::class,[
                'label'=>'Code',
                'attr'=>['class'=>'form-control', 'placeholder'=>""]] )
            ->add('libelle',TextType::class,[
                'label'=>'Libelle',
                'attr'=>['class'=>'form-control', 'placeholder'=>""]])
            ->add('telephone',NumberType::class,[
                'label'=>'Téléphone',
                'attr'=>['class'=>'form-control','placeholder'=>""]])
            ->add('adresse',TextType::class,[
                'label'=>'Adresse',
                'attr'=>['class'=>'form-control','placeholder'=>""]])
            ->add('email',EmailType::class,[
                'label'=>'Email',
                'attr'=>['class'=>'form-control', 'placeholder'=>""]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Structure::class,
        ]);
    }
}
