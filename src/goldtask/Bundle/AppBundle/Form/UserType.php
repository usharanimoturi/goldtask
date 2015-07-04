<?php

namespace Dentrix\Bundle\AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('username', 'text');
		$builder->add('password', 'text');
		$builder->add('firstName','text');
		$builder->add('lastName', 'text');
		$builder->add('email', 'email');
		$builder->add('mobile', 'number');
		$builder->add('state', 'entity', array(
			'mapped'   => false, 
			'class'    => 'BlocMainBundle:State',
			'property' => 'state',
		));
        $builder->add('address', 'textarea');
    }

    public function getName()
    {
        return 'user';
    }
}
