<?php

namespace Member\Options;

use Zend\Stdlib\AbstractOptions;

class MailOptions extends AbstractOptions
{
	private $fromAddress;
	private $from;
	private $password = array();

	public function setFromAddress($fromAddress)
	{
		$this->fromAddress = $fromAddress;
		return $this;
	}

	public function getFromAddress()
	{
		return $this->fromAddress;
	}

	public function setFrom($from)
	{
		$this->from = $from;
		return $this;
	}

	public function getFrom()
	{
		return $this->from;
	}

	public function setPassword($password)
	{
		$this->password = $password;
		return $this;
	}

	public function getPasswordSubject()
	{
		return $this->password['subject'];
	}

	public function getPasswordBody()
	{
		return $this->password['body'];
	}

}
