<?php

namespace App\Form;

use App\Entity\Activite;
use App\Entity\TypeActivite;
use phpDocumentor\Reflection\PseudoTypes\Numeric_;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AxeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

//            ->add('numAxe', TextType::class,[
//                'label' => 'Numéro d\'axe :',
//                'required' => true,
//                'mapped'=>false,
//                //'attr'=>['class'=> '' ]
//            ])
            ->add('typeActivite', EntityType::class, [
                'class'=>TypeActivite::class,
                'label' => 'Type activité :',
                'placeholder'=> 'Sélectionnez le type activité parent',
                'choice_label' =>function(TypeActivite $typeActivite){
                    return $typeActivite->getLibelle();
                },
            ])


            ->add('numActivite', )
            ->add('libelleActivite', TextareaType::class,[
                    'label' => 'Libeelé axe :'
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Activite::class,
        ]);
    }
}
