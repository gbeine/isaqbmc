<?php

return array(
	'view_manager' => array(
		'template_path_stack' => array(
			__DIR__ . '/../view',
		),
		'template_map' => array(
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
			'error/index'             => __DIR__ . '/../view/error/index.phtml',
		),
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
		'exception_template'       => 'error/index',
        'not_found_template'       => 'error/404',
	),

	'controllers' => array(
		'invokables' => array(
			'memberController' => 'Member\Controller\MemberController',
			'passwordController' => 'Member\Controller\PasswordController'
		),
	),

	'service_manager' => array(
		'abstract_factories' => array(
			'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
			'Zend\Log\LoggerAbstractServiceFactory',
		),
	),

	'router' => array(
        'routes' => array(

            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'memberController',
                        'action'     => 'index',
                    ),
                ),
            ),

            'password' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'may_terminate' => true,

                'options' => array(
                    'route'    => '/password',
                    'defaults' => array(
                        'controller' => 'passwordController',
                        'action'     => 'index',
                    ),
                ),

                'child_routes' => array(
                    'request' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/request',
                            'defaults' => array(
                                'controller' => 'passwordController',
                                'action'     => 'request',
                            ),
                        ),
                    ),
                	'reset' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/reset',
                            'defaults' => array(
                                'controller' => 'passwordController',
                                'action'     => 'reset',
                            ),
                        ),
                    ),
                	'confirm' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/confirm',
                            'defaults' => array(
                                'controller' => 'passwordController',
                                'action'     => 'confirm',
                            ),
                        ),
                    ),
                ), // child_routes
            ), // password

            'member' => array(
        		'type' => 'Literal',
        		'may_terminate' => true,

        		'options' => array(
        			'route' => '/member',
        			'defaults' => array(
        				'controller' => 'memberController',
        				'action'     => 'index',
        			),
        		),

                'child_routes' => array(
                    'login' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/login',
                            'defaults' => array(
                                'controller' => 'memberController',
                                'action'     => 'login',
                            ),
                        ),
                    ),
                    'logout' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/logout',
                            'defaults' => array(
                                'controller' => 'memberController',
                                'action'     => 'logout',
                            ),
                        ),
                    ),
                    'authenticate' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/authenticate',
                            'defaults' => array(
                                'controller' => 'memberController',
                                'action'     => 'authenticate',
                            ),
                        ),
                    ),
                    'update' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/update',
                            'defaults' => array(
                                'controller' => 'memberController',
                                'action'     => 'update',
                            ),
                        ),
                    ),
                    'password' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/password',
                            'defaults' => array(
                                'controller' => 'memberController',
                                'action'     => 'password',
                            ),
                        ),
                    ),
				), // child_routes
            ), //member
		), //routes
    ), //route

);
