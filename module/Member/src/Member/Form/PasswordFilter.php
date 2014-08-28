<?php

namespace Member\Form;

use Member\InputFilter\ProvidesEventsInputFilter;

class PasswordFilter extends ProvidesEventsInputFilter
{
    public function __construct()
    {
    	// TODO: get password length from options
        $currentParams = array(
        	'name'       => 'current',
        	'required'   => true,
        	'validators' => array(
        		array(
        			'name'    => 'StringLength',
        			'options' => array( 'min' => 6, ),
       			),
       		),
      		'filters'   => array(
        		array('name' => 'StringTrim'),
        	),
        );
        $this->add($currentParams);

        $new1Params = array(
        		'name'       => 'new1',
        		'required'   => true,
        		'validators' => array(
        			array(
      					'name'    => 'StringLength',
   						'options' => array( 'min' => 6, ),
       				),
        		),
        		'filters'   => array(
        			array('name' => 'StringTrim'),
        		),
        );
        $this->add($new1Params);

        $new2Params = array(
        		'name'       => 'new2',
        		'required'   => true,
        		'validators' => array(
       				array(
  						'name'    => 'StringLength',
       					'options' => array( 'min' => 6, ),
        			),
        		),
        		'filters'   => array(
        			array('name' => 'StringTrim'),
        		),
        );
        $this->add($new2Params);

        $this->getEventManager()->trigger('init', $this);
    }
}
