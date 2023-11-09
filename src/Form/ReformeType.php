<?php

namespace App\Form;

use App\Entity\Reforme;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReformeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle', TextType::class, [
                'label' => 'Libellé',
                'attr' => ['class' => 'form-control', 'placeholder' => ""]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => ['class' => 'form-control', 'placeholder' => ""]
            ])
            // ->add('url', FileType::class, [
            //     'label' => 'Image',
            //     'attr' => ['class' => 'form-control', 'placeholder' => ""]
            // ])
            // ->add('url',UrlType::class, [
            //     'label' => 'Url',
            //     'attr' => ['class' => 'form-control', 'placeholder' => ""]
            // ])
            // ->add('urlAbsolute')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reforme::class,
        ]);
    }
}
