<?php

namespace Member\Options;

use Zend\Stdlib\AbstractOptions;

class LdapOptions extends AbstractOptions
{

    protected $userIdAttribute = 'uid';
	protected $userBase;
	protected $groupMemberAttribute = 'member';
	protected $groupBase;
	protected $logPath;
	protected $server = array();

	public function setUserIdAttribute($userIdAttribute)
	{
		$this->userIdAttribute = $userIdAttribute;
		return $this;
	}

	public function getUserIdAttribute()
	{
		return $this->userIdAttribute;
	}

	public function setUserBase($userBase)
	{
		$this->userBase = $userBase;
		return $this;
	}

	public function getUserBase()
	{
		return $this->userBase;
	}

	public function setGroupMemberAttribute($groupMemberAttribute)
	{
		$this->groupMemberAttribute = $groupMemberAttribute;
		return $this;
	}

	public function getGroupMemberAttribute()
	{
		return $this->groupMemberAttribute;
	}

	public function setGroupBase($groupBase)
	{
		$this->groupBase = $groupBase;
		return $this;
	}

	public function getGroupBase()
	{
		return $this->groupBase;
	}

	public function setLogPath($logPath)
	{
		$this->logPath = $logPath;
		return $this;
	}

	public function getLogPath()
	{
		return $this->logPath;
	}

	public function setServer($server)
	{
		$this->server = $server;
		return $this;
	}

	public function getServer()
	{
		return $this->server;
	}

}