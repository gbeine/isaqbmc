<?php

namespace Member\Options;

use Zend\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions implements
    MemberControllerOptionsInterface,
    AuthenticationOptionsInterface
{
    /**
     * @var bool
     */
    protected $useRedirectParameterIfPresent = true;

    /**
     * @var string
     */
    protected $loginFormRedirectRoute = 'member/login';

    /**
     * @var string
     */
    protected $loginRedirectRoute = 'member';

    /**
     * @var string
     */
    protected $logoutRedirectRoute = 'member/login';

    /**
     * @var int
     */
    protected $loginFormTimeout = 300;

    /**
     * @var array
     */
    protected $authIdentityFields = array( 'email' );

    /**
     * @var int
     */
    protected $passwordCost = 14;

    /**
     * @var int
     */
    protected $passwordMinLength = 12;

    /**
     * set login from redirect route
     *
     * @param string $loginRedirectRoute
     * @return ModuleOptions
     */
    public function setLoginFromRedirectRoute($loginFormRedirectRoute)
    {
        $this->loginFormRedirectRoute = $loginFormRedirectRoute;
        return $this;
    }

    /**
     * get login form redirect route
     *
     * @return string
     */
    public function getLoginFormRedirectRoute()
    {
        return $this->loginFormRedirectRoute;
    }

    /**
     * set login redirect route
     *
     * @param string $loginRedirectRoute
     * @return ModuleOptions
     */
    public function setLoginRedirectRoute($loginRedirectRoute)
    {
        $this->loginRedirectRoute = $loginRedirectRoute;
        return $this;
    }

    /**
     * get login redirect route
     *
     * @return string
     */
    public function getLoginRedirectRoute()
    {
        return $this->loginRedirectRoute;
    }

    /**
     * set logout redirect route
     *
     * @param string $logoutRedirectRoute
     * @return ModuleOptions
     */
    public function setLogoutRedirectRoute($logoutRedirectRoute)
    {
        $this->logoutRedirectRoute = $logoutRedirectRoute;
        return $this;
    }

    /**
     * get logout redirect route
     *
     * @return string
     */
    public function getLogoutRedirectRoute()
    {
        return $this->logoutRedirectRoute;
    }

    /**
     * set use redirect param if present
     *
     * @param bool $useRedirectParameterIfPresent
     * @return ModuleOptions
     */
    public function setUseRedirectParameterIfPresent($useRedirectParameterIfPresent)
    {
        $this->useRedirectParameterIfPresent = $useRedirectParameterIfPresent;
        return $this;
    }

    /**
     * get use redirect param if present
     *
     * @return bool
     */
    public function getUseRedirectParameterIfPresent()
    {
        return $this->useRedirectParameterIfPresent;
    }

    /**
     * set login form timeout
     *
     * @param int $loginFormTimeout
     * @return ModuleOptions
     */
    public function setLoginFormTimeout($loginFormTimeout)
    {
        $this->loginFormTimeout = $loginFormTimeout;
        return $this;
    }

    /**
     * get login form timeout in seconds
     *
     * @return int
     */
    public function getLoginFormTimeout()
    {
        return $this->loginFormTimeout;
    }

    public function setPasswordCost($passwordCost)
    {
        $this->passwordCost = $passwordCost;
        return $this;
    }

    public function getPasswordCost()
    {
        return $this->passwordCost;
    }

    public function setPasswordMinLength($passwordMinLength)
    {
        $this->passwordMinLength = $passwordMinLength;
        return $this;
    }

    public function getPasswordMinLength()
    {
        return $this->passwordMinLength;
    }
}
