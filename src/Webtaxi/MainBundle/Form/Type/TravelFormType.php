<?php

namespace Webtaxi\MainBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TravelFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sourceLongitude', 'hidden')
            ->add('sourceLatitude', 'hidden')
            ->add('destinationLongitude', 'hidden')
            ->add('destinationLatitude', 'hidden')
            ->add('sourceAddress', 'text',  array('label' => 'Išvykimas'))
            ->add('destinationAddress', 'text',  array('label' => 'Atvykimas'))
            ->add('price', 'number',  array('label' => 'Siūloma kaina'))
            ->add('passengerCount', 'number',  array('label' => 'Keleivių skaičius'))
            ->add('distance', 'number',  array('label' => 'Apskaičiuotas atstumas'))
            ->add('save', 'submit', array('label' => 'Pateikti'));
    }

    public function getName()
    {
        return 'travel';
    }

//    public function setDefaultOptions(OptionsResolverInterface $resolver)
//    {
//        $resolver->setDefaults(array(
//            'data_class' => 'Webtaxi\MainBundle\Entity\Travel',
//        ));
//    }
}