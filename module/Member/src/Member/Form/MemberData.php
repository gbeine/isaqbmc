<?php

namespace Member\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Member\Form\ProvidesEventsForm;

class MemberData extends ProvidesEventsForm
{

	public function __construct($name = null)
	{
		parent::__construct($name);

		$this->add(array(
				'name' => 'uid',
				'options' => array( 'label' => 'Login (ro)' ),
				'attributes' => array( 'type' => 'text', 'readonly' => true ),
		));

		$this->add(array(
				'name' => 'uidNumber',
				'options' => array( 'label' => 'Unix Number (ro)' ),
				'attributes' => array( 'type' => 'text', 'readonly' => true ),
		));

		$this->add(array(
				'name' => 'homeDirectory',
				'options' => array( 'label' => 'Unix Home Directory (ro)' ),
				'attributes' => array( 'type' => 'text', 'readonly' => true ),
		));

		$this->add(array(
				'name' => 'loginShell',
				'options' => array( 'label' => 'Unix Login Shell (ro)' ),
				'attributes' => array( 'type' => 'text', 'readonly' => true ),
		));

		$this->add(array(
				'name' => 'mailAcceptAddress',
				'options' => array( 'label' => 'E-Mail (ro)' ),
				'attributes' => array( 'type' => 'text', 'readonly' => true ),
		));

		$this->add(array(
				'name' => 'mailForwardAddress',
				'options' => array( 'label' => 'Forward E-Mail' ),
				'attributes' => array( 'type' => 'text' ),
		));

		$this->add(array(
				'name' => 'mail',
				'options' => array( 'label' => 'Visible E-Mail' ),
				'attributes' => array( 'type' => 'text' ),
		));

		$this->add(array(
				'name' => 'telephoneNumber',
				'options' => array( 'label' => 'Telephone Number' ),
				'attributes' => array( 'type' => 'text' ),
		));

		$this->add(array(
				'type' => 'Zend\Form\Element\Textarea',
				'name' => 'postalAddress',
				'options' => array( 'label' => 'Address' ),
		));

		$this->add(array(
				'name' => 'organization',
				'options' => array( 'label' => 'Organization' ),
				'attributes' => array( 'type' => 'text' ),
		));

		$this->add(array(
				'name' => 'cn',
				'options' => array( 'label' => 'Given Name' ),
				'attributes' => array( 'type' => 'text' ),
		));

		$this->add(array(
				'name' => 'sn',
				'options' => array( 'label' => 'Surname' ),
				'attributes' => array( 'type' => 'text' ),
		));

		$submitElement = new Element\Button('submit');
		$submitElement->setLabel('Update');
		$submitElement->setAttributes(array( 'type'  => 'submit' ));

		$this->add($submitElement, array(
				'priority' => -100,
		));

		$this->getEventManager()->trigger('init', $this);
	}

}
