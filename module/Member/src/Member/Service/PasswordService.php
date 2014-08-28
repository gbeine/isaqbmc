<?php
namespace Member\Service;

use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\ServiceManager\ServiceManager;
use Zend\Ldap\Attribute as Attribute;
use Zend\Mail\Message as Message;
use Zend\Mail\Transport\Sendmail as Transport;
use Member\EventManager\EventProvider;
use Member\Options\ModuleOptions;
use Member\Entity\Member;

class PasswordService extends EventProvider implements ServiceManagerAwareInterface
{

	const ALPHABET = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789-!@#$%&*()_+,./?;:";

	/**
	 * @var MemberService
	 */
	protected $memberService;

	/**
	 * @var ServiceManager
	 */
	protected $serviceManager;

    /**
     * @var ModuleOptions
     */
    protected $options;

	public function resetPassword($identity)
	{
		$memberService = $this->getMemberService();
		$dn = $memberService->buildDn($identity);

		// Abbrechen, wenn kein Eintrag existiert
		if (!$memberService->existsByDn($dn)) {
			return false;
		}

		$entry = $memberService->findByDn($dn);

		//Abbrechen, wenn keine Mailadresse hinterlegt
		if (strlen($entry->getMail()) < 1) {
			return false;
		}

		$length = $this->getOptions()->getPasswordMinLength();
		$password = $this->generatePassword($length);

		$this->updatePassword($dn, $password);
		$this->emailPassword($entry, $password);

		return true;
	}

	public function emailPassword(Member $entry, $password)
	{
		$options = $this->getServiceManager()->get('member_mail_options');
		$message = new Message();
		$message
			->addFrom($options->getFromAddress(), $options->getFrom())
			->addTo($entry->getMail(), $entry->getName())
			->setSubject($options->getPasswordSubject());
		$body = $options->getPasswordBody();
		$body = preg_replace("/#name#/", $entry->getName(), $body);
		$body = preg_replace("/#password#/", $password, $body);
		$message->setBody($body);

		// TODO: inject transport
		$transport = new Transport();
		$transport->send($message);
	}

	public function updatePassword($dn, $password)
	{
		$ldap = $this->getServiceManager()->get('member_ldap_connection');
		$ldap->bind();
		$entry = $ldap->getEntry($dn);
		Attribute::setPassword($entry, $password, Attribute::PASSWORD_HASH_SSHA);
		$ldap->update($dn, $entry);
	}

	/**
	 * Generates a random password from a string
	 *
	 * @param unknown $length
	 * @return string
	 */
	private function generatePassword($length = 8)
	{
		$alphabet = static::ALPHABET;
		$password = array();
		$alphabetLength = strlen($alphabet) - 1;
		for ($i = 0; $i < $length; $i++) {
			$n = rand(0, $alphabetLength);
			$password[] = $alphabet[$n];
		}
		return implode($password);
	}

    /**
     * get service options
     *
     * @return ModuleOptions
     */
    public function getOptions()
    {
        if (!$this->options instanceof ModuleOptions) {
            $this->setOptions($this->getServiceManager()->get('member_module_options'));
        }
        return $this->options;
    }

    /**
     * set service options
     *
     * @param ModuleOptions $options
     */
    public function setOptions(ModuleOptions $options)
    {
        $this->options = $options;
        return $this;
    }

	/**
	 * get member service
	 *
	 * @return MemberService
	 */
	public function getMemberService()
	{
		if (!$this->memberService instanceof MemberService) {
			$this->setMemberService($this->getServiceManager()->get('member_service'));
		}
		return $this->memberService;
	}

	/**
	 * set member service
	 *
	 * @param MemberService $memberService
	 */
	public function setMemberService(MemberService $memberService)
	{
		$this->memberService = $memberService;
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
