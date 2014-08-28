<?php

namespace Member\Controller;

use Zend\Form\Form;
use Zend\Mvc\Controller\AbstractActionController;
use Member\Options\RoutingOptionsInterface;
use Member\Service\PasswordService;

class PasswordController extends AbstractActionController
{
	const CONTROLLER_NAME = 'passwordController';

	/**
	 * @var PasswordService
	 */
	protected $passwordService;

	/**
	 * @var Form
	 */
	protected $passwordResetForm;

	/**
	 * @var MemberControllerOptionsInterface
	 */
	protected $options;

	public function indexAction()
	{
		$form = $this->getResetPasswordForm();

		return array(
				'resetPasswordForm' => $form,
				'redirect' => false,
		);
	}

	public function requestAction()
	{
		$request = $this->getRequest();

		if (!$request->isPost()) {
			return $this->redirect()->toRoute($this->getOptions()->getLoginRedirectRoute());
		}

		$form = $this->getResetPasswordForm();
		$form->setData($request->getPost());

		if (!$form->isValid()) {
			return $this->redirect()->toRoute($this->getOptions()->getLoginRedirectRoute());
		}

		return $this->forward()->dispatch(static::CONTROLLER_NAME, array('action' => 'reset'));
	}

	public function resetAction()
	{
		$identity = $this->getRequest()->getPost()->get('identity');

		$passwordService = $this->getPasswordService();

		$result = $passwordService->resetPassword($identity);

		if ($result) {
#			return $this->redirect()->toRoute($this->getOptions()->getLoginRedirectRoute());
			return $this->forward()->dispatch(static::CONTROLLER_NAME, array('action' => 'confirm'));
		}

		return $this->redirect()->toRoute($this->getOptions()->getLoginRedirectRoute());
	}

	public function confirmAction()
	{

	}

	public function getResetPasswordForm()
	{
		if (!$this->passwordResetForm) {
			$this->setResetPasswordForm($this->getServiceLocator()->get('password_reset_form'));
		}
		return $this->passwordResetForm;
	}

	public function setResetPasswordForm(Form $passwordResetForm)
	{
		$this->passwordResetForm = $passwordResetForm;
		return $this;
	}

    public function getPasswordService()
    {
        if (!$this->passwordService) {
            $this->passwordService = $this->getServiceLocator()->get('password_service');
        }
        return $this->passwordService;
    }

    public function setPasswordService(PasswordService $passwordService)
    {
        $this->passwordService = $passwordService;
        return $this;
    }

	/**
	 * set options
	 *
	 * @param RoutingOptionsInterface $options
	 * @return PasswordController
	 */
	public function setOptions(RoutingOptionsInterface $options)
	{
		$this->options = $options;
		return $this;
	}

	/**
	 * get options
	 *
	 * @return RoutingOptionsInterface
	 */
	public function getOptions()
	{
		if (!$this->options instanceof RoutingOptionsInterface) {
			$this->setOptions($this->getServiceLocator()->get('member_module_options'));
		}
		return $this->options;
	}

}
