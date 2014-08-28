<?php

namespace Member\Controller;

use Zend\Form\Form;
use Zend\Mvc\Controller\AbstractActionController;
use Member\Options\MemberControllerOptionsInterface;
use Member\Service\MemberService;

class MemberController extends AbstractActionController
{
	const CONTROLLER_NAME = 'memberController';

	/**
	 * @var MemberService
	 */
	protected $memberService;

	/**
     * @var Form
     */
    protected $loginForm;

    /**
     * @var Form
     */
    protected $memberDataForm;

    /**
     * @todo Make this dynamic / translation-friendly
     * @var string
     */
    protected $failedLoginMessage = 'Authentication failed. Please try again.';

    /**
     * @var MemberControllerOptionsInterface
     */
    protected $options;

    /**
     * User page
     */
    public function indexAction()
	{
        if (!$this->memberAuthentication()->hasIdentity()) {
            return $this->redirect()->toRoute($this->getOptions()->getLoginFormRedirectRoute());
        }

        $identity = $this->memberAuthentication()->getIdentity();
        $member = $this->getMemberService()->findByUid($identity);

        $form = $this->getMemberDataForm();
		$form->bind($member);
        // here we go

        return array(
			'memberDataForm' => $form,
			'redirect' => false,
		);
	}

    /**
     * Login form
     */
	public function loginAction()
	{
		if ($this->memberAuthentication()->hasIdentity()) {
			return $this->redirect()->toRoute($this->getOptions()->getLoginRedirectRoute());
		}

		$request = $this->getRequest();
		$form = $this->getLoginForm();

		if ($this->getOptions()->getUseRedirectParameterIfPresent() && $request->getQuery()->get('redirect')) {
			$redirect = $request->getQuery()->get('redirect');
		} else {
			$redirect = false;
		}

		if (!$request->isPost()) {
			return array(
				'loginForm' => $form,
				'redirect' => $redirect,
			);
		}

		$form->setData($request->getPost());

		if (!$form->isValid()) {
			$this->flashMessenger()->setNamespace('member-login-form')->addMessage($this->failedLoginMessage);
			return $this->redirect()->toUrl($this->url()->fromRoute($this->getOptions()->getLoginRedirectRoute()) . ($redirect ? '?redirect='. rawurlencode($redirect) : ''));
		}

		$this->memberAuthentication()->reset();

		return $this->forward()->dispatch(static::CONTROLLER_NAME, array('action' => 'authenticate'));
	}

	/**
	 * Logout and clear the identity
	 */
	public function logoutAction()
	{
		$this->memberAuthentication()->logout();

		$redirect = $this->params()->fromPost('redirect', $this->params()->fromQuery('redirect', false));

        if ($this->getOptions()->getUseRedirectParameterIfPresent() && $redirect) {
            return $this->redirect()->toUrl($redirect);
        }

        return $this->redirect()->toRoute($this->getOptions()->getLogoutRedirectRoute());
	}

	/**
	 * General-purpose authentication action
	 */
	public function authenticateAction()
	{
		if ($this->memberAuthentication()->hasIdentity()) {
			return $this->redirect()->toRoute($this->getOptions()->getLoginRedirectRoute());
		}

		$redirect = $this->params()->fromPost('redirect', $this->params()->fromQuery('redirect', false));

		$result = $this->memberAuthentication()->authenticate($this->getRequest()->getPost());

		if (!$result->isValid()) {
			$this->memberAuthentication()->reset();
            $this->flashMessenger()->setNamespace('member-login-form')->addMessage($this->failedLoginMessage);
			return $this->redirect()->toUrl($this->url()->fromRoute($this->getOptions()->getLoginFormRedirectRoute()) . ($redirect ? '?redirect='. rawurlencode($redirect) : ''));
		}

		return $this->redirect()->toRoute($this->getOptions()->getLoginRedirectRoute());
	}

	public function updateAction()
	{
		if (!$this->memberAuthentication()->hasIdentity()) {
			return $this->redirect()->toRoute($this->getOptions()->getLoginFormRedirectRoute());
		}
		$request = $this->getRequest();
		$post = $request->getPost();
		$identity = $this->memberAuthentication()->getIdentity();

		$member = $this->getMemberService()->findByUid($identity);
		$member->setMailForwardAddress($post->get('mailForwardAddress'));
		$member->setMail($post->get('mail'));
		$member->setCn($post->get('cn'));
		$member->setSn($post->get('sn'));
		$member->setOrganization($post->get('organization'));
		$member->setTelephoneNumber($post->get('telephoneNumber'));
		$member->setPostalAddress($post->get('postalAddress'));

		$this->getMemberService()->updateMember($member);

		return $this->redirect()->toRoute($this->getOptions()->getLoginRedirectRoute());
	}

	public function passwordAction()
	{
		if (!$this->memberAuthentication()->hasIdentity()) {
			return $this->redirect()->toRoute($this->getOptions()->getLoginFormRedirectRoute());
		}

		$redirect = $this->params()->fromPost('redirect', $this->params()->fromQuery('redirect', false));
		$identity = $this->memberAuthentication()->getIdentity();
		$request = $this->getRequest();
		$form = $this->getPasswordForm();

		if (!$request->isPost()) {
			return array(
				'passwordForm' => $form,
				'redirect' => $redirect,
			);
		}

		$form->setData($request->getPost());

		if (!$form->isValid()) {
			$this->flashMessenger()->setNamespace('member-password-form')->addMessage('Password to short');
			return $this->redirect()->toUrl($this->url()->fromRoute('member/password') . ($redirect ? '?redirect='. rawurlencode($redirect) : ''));
		}

		$authAdapter = $this->getServiceLocator()->get('member_auth_adapter');
		$authAdapter->setIdentity($identity);
		$authAdapter->setCredential($request->getPost()->get('current'));
		$result = $authAdapter->authenticate();

		if (!$result->isValid()) {
			$this->flashMessenger()->setNamespace('member-password-form')->addMessage('Current password is wrong');
			return $this->redirect()->toUrl($this->url()->fromRoute('member/password') . ($redirect ? '?redirect='. rawurlencode($redirect) : ''));
		}

		$new1 = $request->getPost()->get('new1');
		$new2 = $request->getPost()->get('new2');

		if ($new1 !== $new2) {
			$this->flashMessenger()->setNamespace('member-password-form')->addMessage('New password does not match confirmation');
			return $this->redirect()->toUrl($this->url()->fromRoute('member/password') . ($redirect ? '?redirect='. rawurlencode($redirect) : ''));
		}

		$dn = $this->getMemberService()->buildDn($identity);
		$passwordService = $this->getServiceLocator()->get('password_service');

		$passwordService->updatePassword($dn, $new1);

		$this->flashMessenger()->setNamespace('member-password-form')->addMessage('Password updated');
		return $this->redirect()->toUrl($this->url()->fromRoute('member/password'));
	}

    public function getMemberDataForm()
    {
        if (!$this->memberDataForm) {
            $this->setMemberDataForm($this->getServiceLocator()->get('member_data_form'));
        }
        return $this->memberDataForm;
    }

    public function setMemberDataForm(Form $memberDataForm)
    {
        $this->memberDataForm = $memberDataForm;
        return $this;
    }

    public function getLoginForm()
    {
    	if (!$this->loginForm) {
    		$this->setLoginForm($this->getServiceLocator()->get('member_login_form'));
    	}
    	return $this->loginForm;
    }

    public function setLoginForm(Form $loginForm)
    {
    	$this->loginForm = $loginForm;
    	$fm = $this->flashMessenger()->setNamespace('member-login-form')->getMessages();
    	if (isset($fm[0])) {
    		$this->loginForm->setMessages(
    				array('identity' => array($fm[0]))
    		);
    	}
    	return $this;
    }

    public function getPasswordForm()
    {
    	if (!$this->passwordForm) {
    		$this->setPasswordForm($this->getServiceLocator()->get('member_password_form'));
    	}
    	return $this->passwordForm;
    }

    public function setPasswordForm(Form $passwordForm)
    {
    	$this->passwordForm = $passwordForm;
    	$fm = $this->flashMessenger()->setNamespace('member-password-form')->getMessages();
    	if (isset($fm[0])) {
    		$this->passwordForm->setMessages(
    				array('current' => array($fm[0]))
    		);
    	}
    	return $this;
    }

    public function getMemberService()
    {
        if (!$this->memberService) {
            $this->memberService = $this->getServiceLocator()->get('member_service');
        }
        return $this->memberService;
    }

    public function setMemberService(MemberService $memberService)
    {
        $this->memberService = $memberService;
        return $this;
    }

    /**
     * set options
     *
     * @param MemberControllerOptionsInterface $options
     * @return MemberController
     */
    public function setOptions(MemberControllerOptionsInterface $options)
    {
    	$this->options = $options;
    	return $this;
    }

    /**
     * get options
     *
     * @return MemberControllerOptionsInterface
     */
    public function getOptions()
    {
    	if (!$this->options instanceof MemberControllerOptionsInterface) {
    		$this->setOptions($this->getServiceLocator()->get('member_module_options'));
    	}
    	return $this->options;
    }

}
