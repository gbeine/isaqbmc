<?php

namespace Member\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Member\Form\ProvidesEventsForm;

class Password extends ProvidesEventsForm
{

    public function __construct($name = null)
    {
        parent::__construct($name);

        $this->add(array(
            'name' => 'current',
            'options' => array(
                'label' => 'Current password',
            ),
            'attributes' => array(
                'type' => 'password'
            ),
        ));

        $this->add(array(
            'name' => 'new1',
            'options' => array(
                'label' => 'New password',
            ),
            'attributes' => array(
                'type' => 'password',
            ),
        ));

        $this->add(array(
            'name' => 'new2',
            'options' => array(
                'label' => 'Confirm new password',
            ),
            'attributes' => array(
                'type' => 'password',
            ),
        ));

        $submitElement = new Element\Button('submit');
        $submitElement
            ->setLabel('Change password')
            ->setAttributes(array(
                'type'  => 'submit',
            ));

        $this->add($submitElement, array(
            'priority' => -100,
        ));

        $this->getEventManager()->trigger('init', $this);
    }

}
