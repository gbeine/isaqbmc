<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Member;

use Zend\Config\Reader\Ini as ConfigReader;
use Zend\Config\Config;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getControllerPluginConfig()
    {
        return array(
        	'factories' => array(
                'memberAuthentication' => function ($sm) {
                    $serviceLocator = $sm->getServiceLocator();
                    $authService = $serviceLocator->get('member_auth_service');
                    $authAdapter = $serviceLocator->get('member_auth_adapter');
                    $controllerPlugin = new \Member\Controller\Plugin\MemberAuthentication;
                    $controllerPlugin->setAuthService($authService);
                    $controllerPlugin->setAuthAdapter($authAdapter);
                    return $controllerPlugin;
                },
            ),
        );
    }

    public function getServiceConfig()
    {
    	return array(

            'invokables' => array(
                'member_service' => 'Member\Service\MemberService',
                'password_service' => 'Member\Service\PasswordService',
            ),

    		'factories' => array(
       			'member_ldap_config' => function ($sm) {
       				$configPath = __DIR__ . '/config/config.ldap.ini';
       				$configReader = new ConfigReader();
       				$configData = $configReader->fromFile($configPath);
       				return new Config($configData, true);
       			},
       			'member_mail_config' => function ($sm) {
       				$configPath = __DIR__ . '/config/config.mail.ini';
       				$configReader = new ConfigReader();
       				$configData = $configReader->fromFile($configPath);
       				return new Config($configData, true);
       			},
                'member_mail_options' => function ($sm) {
                	$config = $sm->get('member_mail_config');
					$options = $config->production->mail->toArray();
               		return new \Member\Options\MailOptions($options);
                },
       			'member_ldap_connection' => function ($sm) {
       				$config = $sm->get('member_ldap_config');
       				$options = $config->production->ldap->server->toArray();
       				return new \Zend\Ldap\Ldap($options);
       			},
                'member_ldap_options' => function ($sm) {
                	$config = $sm->get('member_ldap_config');
					$options = $config->production->ldap->toArray();
               		return new \Member\Options\LdapOptions($options);
                },
                'member_module_options' => function ($sm) {
                    return new \Member\Options\ModuleOptions(array());
                },
    			'member_wrapper_service' => function ($sm) {
    				return new \Member\Wrapper\LdapMember();
    			},
                'member_auth_service' => function ($sm) {
    				return new \Zend\Authentication\AuthenticationService();
    			},
    			'member_auth_adapter' => function ($sm) {
    				return new \Member\Authentication\Adapter\MemberAdapter($sm);
    			},
                'member_data_hydrator' => function ($sm) {
                    $hydrator = new \Zend\Stdlib\Hydrator\ClassMethods(false);
                    return $hydrator;
                },
    			'member_login_form' => function($sm) {
                    $form = new \Member\Form\Login(null);
                    $form->setInputFilter(new \Member\Form\LoginFilter());
                    return $form;
                },
    			'member_password_form' => function($sm) {
                    $form = new \Member\Form\Password(null);
                    $form->setInputFilter(new \Member\Form\PasswordFilter());
                    return $form;
                },
                'member_data_form' => function($sm) {
                    $form = new \Member\Form\MemberData(null);
                    $form->setHydrator($sm->get('member_data_hydrator'));
                    return $form;
                },
    			'password_reset_form' => function($sm) {
                    $form = new \Member\Form\ResetPassword(null);
                    return $form;
                },
            ),
    	);
  	}

  	public function getViewHelperConfig()
  	{
  		return array(
  			'factories' => array(
				'memberData' => function ($sm) {
					$sl = $sm->getServiceLocator();
					$viewHelper = new \Member\View\Helper\MemberData();
					$viewHelper->setAuthService($sl->get('member_auth_service'));
					$viewHelper->setMemberService($sl->get('member_service'));
					return $viewHelper;
				},
			),
  		);
  	}

}
