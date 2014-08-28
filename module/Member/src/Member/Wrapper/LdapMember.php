<?php

namespace Member\Wrapper;

use Zend\Ldap\Attribute;
use Member\Entity\Member;

class LdapMember
{

	public function fromArray($data)
	{
		$member = new Member();
		$member->setDn($data['dn']);
		$member->setCn($data['cn'][0]);
		$member->setSn($data['sn'][0]);
		$member->setOrganization($data['o'][0]);
		$member->setMail($data['mail'][0]);
		$member->setTelephoneNumber($data['telephonenumber'][0]);
		$member->setPostalAddress($data['postaladdress'][0]);
		$member->setMailAcceptAddress($data['susemailacceptaddress'][0]);
		$member->setMailForwardAddress($data['susemailforwardaddress'][0]);
		$member->setUid($data['uid'][0]);
		$member->setUidNumber($data['uidnumber'][0]);
		$member->setHomeDirectory($data['homedirectory'][0]);
		$member->setLoginShell($data['loginshell'][0]);
		return $member;
	}

	public function fromMember(Member $member) {
		$data = array();
		$data['dn'] = $member->getDn();
		Attribute::setAttribute($data, 'cn', $member->getCn());
		Attribute::setAttribute($data, 'sn', $member->getSn());
		Attribute::setAttribute($data, 'o', $member->getOrganization());
		Attribute::setAttribute($data, 'mail', $member->getMail());
		Attribute::setAttribute($data, 'telephonenumber', $member->getTelephoneNumber());
		Attribute::setAttribute($data, 'postaladdress', $member->getPostalAddress());
		Attribute::setAttribute($data, 'susemailforwardaddress', $member->getMailForwardAddress());
		return $data;
	}
}
