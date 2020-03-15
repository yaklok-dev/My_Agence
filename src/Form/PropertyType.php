<?php

namespace App\Form;

use App\Entity\Property;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('surface')
            ->add('rooms')
            ->add('bedrooms')
            ->add('floor')
            ->add('price')
            ->add('sold')
            ->add('city')
            ->add('adresse')
            ->add('postal_code')
            ->add('heat' ,ChoiceType::class,[
                'choices'=>$this->getHeatChoice()
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
        ]);
    }

    public function getHeatChoice(){
        $choices=Property::HEAT;
        $output=[];
        foreach($choices as $k=>$v){
            $output[$v]=$k;
        }return $output;
    }
}
