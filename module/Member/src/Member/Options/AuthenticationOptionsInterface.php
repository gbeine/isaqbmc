<?php

namespace Member\Options;

use Member\Options\PasswordOptionsInterface;

interface AuthenticationOptionsInterface extends PasswordOptionsInterface
{

    /**
     * set login form timeout in seconds
     *
     * @param int $loginFormTimeout
     */
    public function setLoginFormTimeout($loginFormTimeout);

    /**
     * set login form timeout in seconds
     *
     * @param int $loginFormTimeout
     */
    public function getLoginFormTimeout();

}
