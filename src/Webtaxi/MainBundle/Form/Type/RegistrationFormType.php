<?php
/**
 * Created by PhpStorm.
 * User: grt
 * Date: 14-11-14
 * Time: 23:27
 */
namespace Webtaxi\MainBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // add your custom field
        $builder->add('firstName');
        $builder->add('lastName');
    }

    public function getParent()
    {
        return 'fos_user_registration';
    }

    public function getName()
    {
        return 'webtaxi_user_registration';
    }
}