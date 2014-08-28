<?php

namespace Member\Controller\Plugin;

use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Result;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\Stdlib\ParametersInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Member\Authentication\Adapter\MemberAdapter as AuthAdapter;

class MemberAuthentication extends AbstractPlugin
{
    /**
     * @var AuthAdapter
     */
    protected $authAdapter;

    /**
     * @var AuthenticationService
     */
    protected $authService;

    /**
     * Authenticates using service and adapter
     *
     * @param  Zend\Stdlib\ParametersInterface $params
     * @return Result
     * @throws Exception\RuntimeException
     */
    public function authenticate(ParametersInterface $params)
    {
    	$this->authAdapter->setIdentity($params->get('identity'));
    	$this->authAdapter->setCredential($params->get('credential'));

    	return $this->authService->authenticate($this->authAdapter);
    }

    /**
     * Clears the identity in case of session errors
     */
    public function reset()
    {
		$this->authService->clearIdentity();
    }

    /**
     * Clears the identity in case of logout
     */
    public function logout()
    {
		$this->authService->clearIdentity();
    }

    /**
     * Proxy convenience method
     *
     * @return bool
     */
    public function hasIdentity()
    {
        return $this->getAuthService()->hasIdentity();
    }

    /**
     * Proxy convenience method
     *
     * @return mixed
     */
    public function getIdentity()
    {
        return $this->getAuthService()->getIdentity();
    }

    /**
     * Get authAdapter.
     *
     * @return AuthAdapter
     */
    public function getAuthAdapter()
    {
        return $this->authAdapter;
    }

    /**
     * Set authAdapter.
     *
     * @param authAdapter $authAdapter
     */
    public function setAuthAdapter(AuthAdapter $authAdapter)
    {
        $this->authAdapter = $authAdapter;
        return $this;
    }

    /**
     * Get authService.
     *
     * @return AuthenticationService
     */
    public function getAuthService()
    {
        return $this->authService;
    }

    /**
     * Set authService.
     *
     * @param AuthenticationService $authService
     */
    public function setAuthService(AuthenticationService $authService)
    {
        $this->authService = $authService;
        return $this;
    }

}
