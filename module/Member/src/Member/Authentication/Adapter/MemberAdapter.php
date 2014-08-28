<?php

namespace Member\Authentication\Adapter;

use Zend\Authentication\Adapter\AbstractAdapter;
use Zend\Authentication\Result;
use Zend\ServiceManager\ServiceLocatorInterface;

class MemberAdapter extends AbstractAdapter
{

    /**
     * @var ServiceLocatorInterface
     */
    protected $serviceLocator;

    public function __construct(ServiceLocatorInterface $sm) {
      	$this->setServiceLocator($sm);
    }

	public function authenticate() {
		$ldap = $this->getServiceLocator()->get('member_ldap_connection');
		$memberService = $this->getServiceLocator()->get('member_service');

		$dn = $memberService->buildDn($this->getIdentity());

		try {
			$ldap->bind($dn, $this->getCredential());
			$result = new Result(Result::SUCCESS, $this->getIdentity());
		} catch (\Zend\Ldap\Exception\LdapException $e) {
			$messages = array( $e->getMessage() );
			$result = new Result(Result::FAILURE, $this->getIdentity(), $messages);
		}

		return $result;
	}

    /**
     * Set serviceManager instance
     *
     * @param  ServiceLocatorInterface $serviceLocator
     * @return void
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * Retrieve serviceManager instance
     *
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

}
