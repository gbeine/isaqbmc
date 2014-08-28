<?php

namespace Member\Service;

use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\ServiceManager\ServiceManager;
use Member\EventManager\EventProvider;
use Member\Options\LdapOptions;
use Member\Entity\Member;

class MemberService extends EventProvider implements ServiceManagerAwareInterface
{
    /**
     * @var ServiceManager
     */
    protected $serviceManager;

    /**
     * @var LdapOptions
     */
    protected $options;

	public function buildDn($param)
	{
		$baseDn = $this->getOptions()->user_base;
		$userId = $this->getOptions()->user_id_attribute;

		$userDn = $userId . '=' . $param . ',' . $baseDn;

		return $userDn;
	}

	/**
	 *
	 * @param Member $param
	 */
	public function findByUid($param)
	{
		$dn = $this->buildDn($param);
		return $this->findByDn($dn);
	}

	/**
	 *
	 * @param Member $param
	 */
	public function findByDn($param)
	{
		$ldap = $this->getServiceManager()->get('member_ldap_connection');
		$ldap->bind();
		$wrapper = $this->getServiceManager()->get('member_wrapper_service');
		return $wrapper->fromArray($ldap->getEntry($param));
	}

	public function existsByUid($param)
	{
		$dn = $this->buildDn($param);
		return $this->existsByDn($dn);
	}

	public function existsByDn($param)
	{
		$ldap = $this->getServiceManager()->get('member_ldap_connection');
		$ldap->bind();
		return $ldap->exists($param);
	}

	public function updateMember($entry)
	{
		$ldap = $this->getServiceManager()->get('member_ldap_connection');
		$ldap->bind();
		$wrapper = $this->getServiceManager()->get('member_wrapper_service');
		$data = $wrapper->fromMember($entry);
		$ldap->update($entry->getDn(), $data);
	}

    /**
     * get service options
     *
     * @return LdapOptions
     */
    public function getOptions()
    {
        if (!$this->options instanceof LdapOptions) {
            $this->setOptions($this->getServiceManager()->get('member_ldap_options'));
        }
        return $this->options;
    }

    /**
     * set service options
     *
     * @param LdapOptions $options
     */
    public function setOptions(LdapOptions $options)
    {
        $this->options = $options;
        return $this;
    }

    /**
     * Retrieve service manager instance
     *
     * @return ServiceManager
     */
    public function getServiceManager()
    {
        return $this->serviceManager;
    }

    /**
     * Set service manager instance
     *
     * @param ServiceManager $serviceManager
     * @return User
     */
    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
        return $this;
    }
}
