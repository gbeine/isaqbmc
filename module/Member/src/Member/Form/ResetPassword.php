<?php

namespace Member\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Member\Form\ProvidesEventsForm;

class ResetPassword extends ProvidesEventsForm
{

    public function __construct($name = null)
    {
        parent::__construct($name);

        $this->add(array(
            'name' => 'identity',
            'options' => array(
                'label' => 'Login',
            ),
            'attributes' => array(
                'type' => 'text'
            ),
        ));

        $submitElement = new Element\Button('submit');
        $submitElement
            ->setLabel('Send new password')
            ->setAttributes(array(
                'type'  => 'submit',
            ));

        $this->add($submitElement, array(
            'priority' => -100,
        ));

        $this->getEventManager()->trigger('init', $this);
    }

}
