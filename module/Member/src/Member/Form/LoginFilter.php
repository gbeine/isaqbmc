<?php

namespace Member\Form;

use Member\InputFilter\ProvidesEventsInputFilter;

class LoginFilter extends ProvidesEventsInputFilter
{
    public function __construct()
    {
        $identityParams = array(
            'name'       => 'identity',
            'required'   => true,
        	'validators' => array(
        		array(
        			'name'    => 'StringLength',
        			'options' => array(
        				'min' => 2,
        			),
       			),
       		),
        		            'filters'   => array(
                array('name' => 'StringTrim'),
            ),
        );

        $this->add($identityParams);

        $passwordParams = array(
        	'name'       => 'credential',
        	'required'   => true,
        	'validators' => array(
        		array(
        			'name'    => 'StringLength',
        			'options' => array(
        				'min' => 6,
        			),
       			),
       		),
      		'filters'   => array(
        		array('name' => 'StringTrim'),
        	),
        );

        $this->add($passwordParams);

        $this->getEventManager()->trigger('init', $this);
    }
}
