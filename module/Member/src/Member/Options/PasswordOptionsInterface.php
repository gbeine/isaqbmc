<?php

namespace Member\Options;

interface PasswordOptionsInterface
{
	/**
     * set password minimum length
     *
     * @param int $passwordMinLength
     * @return PasswordOptionsInterface
	 */
	public function setPasswordMinLength($min);

    /**
     * get password minimum length
     *
     * @return int
     */
	public function getPasswordMinLength();

    /**
     * set password cost
     *
     * @param int $passwordCost
     * @return PasswordOptionsInterface
     */
    public function setPasswordCost($cost);

    /**
     * get password cost
     *
     * @return int
     */
    public function getPasswordCost();
}
