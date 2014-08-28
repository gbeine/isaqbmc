<?php

namespace Member\Entity;

class Member
{
	private $dn;
	private $cn;
	private $sn;
	private $o;
	private $mail;
	private $telephoneNumber;
	private $postalAddress;
	private $mailAcceptAddress;
	private $mailForwardAddress;
	private $uid;
	private $uidNumber;
	private $homeDirectory;
	private $loginShell;

	public function setDn($dn)
	{
		$this->dn = $dn;
	}

	public function getDn()
	{
		return $this->dn;
	}

	public function setCn($cn)
	{
		$this->cn = $cn;
	}

	public function getCn()
	{
		return $this->cn;
	}

	public function setSn($sn)
	{
		$this->sn = $sn;
	}

	public function getSn()
	{
		return $this->sn;
	}

	public function getName()
	{
		return $this->getCn() . ' ' . $this->getSn();
	}

	public function setOrganization($o)
	{
		$this->o = $o;
	}

	public function getOrganization()
	{
		return $this->o;
	}

	public function setMail($mail)
	{
		$this->mail = $mail;
	}

	public function getMail()
	{
		return $this->mail;
	}

	public function setTelephoneNumber($telephoneNumber)
	{
		$this->telephoneNumber = $telephoneNumber;
	}

	public function getTelephoneNumber()
	{
		return $this->telephoneNumber;
	}

	public function setPostalAddress($postalAddress)
	{
		$this->postalAddress = $postalAddress;
	}

	public function getPostalAddress()
	{
		return $this->postalAddress;
	}

	public function setMailAcceptAddress($mailAcceptAddress)
	{
		$this->mailAcceptAddress = $mailAcceptAddress;
	}

	public function getMailAcceptAddress()
	{
		return $this->mailAcceptAddress;
	}

	public function setMailForwardAddress($mailForwardAddress)
	{
		$this->mailForwardAddress = $mailForwardAddress;
	}

	public function getMailForwardAddress()
	{
		return $this->mailForwardAddress;
	}

	public function setUid($uid)
	{
		$this->uid = $uid;
	}

	public function getUid()
	{
		return $this->uid;
	}

	public function setUidNumber($uidNumber)
	{
		$this->uidNumber = $uidNumber;
	}

	public function getUidNumber()
	{
		return $this->uidNumber;
	}

	public function setHomeDirectory($homeDirectory)
	{
		$this->homeDirectory = $homeDirectory;
	}

	public function getHomeDirectory()
	{
		return $this->homeDirectory;
	}

	public function setLoginShell($loginShell)
	{
		$this->loginShell = $loginShell;
	}

	public function getLoginShell()
	{
		return $this->loginShell;
	}

}