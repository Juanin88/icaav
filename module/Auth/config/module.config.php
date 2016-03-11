<?php
/**
 * Auth Module
 * 
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
return array(
		// The following section is new and should be added to your file
		'router' => array(
				'routes' => array(
						'auth' => array(
								'type'    => 'segment',
								'options' => array(
										//'route'    => '/auth[/:action][/:id]',
										'route'    => '/auth/auth/index',
										'constraints' => array(
												'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
												'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
												'id'     	 => '[a-zA-Z0-9_-]*',
										)
									/*	'defaults' => array(
												'controller' => 'Auth\Controller\Auth',
												'action'     => 'index',
										),*/
								),
						),
			            // The following is a route to simplify getting started creating
			            // new controllers and actions without needing to create a new
			            // module. Simply drop new controllers in, and you can access them
			            // using the path /application/:controller/:action
			            'application' => array(
			                'type'    => 'Literal',
			                'options' => array(
			                    'route'    => '/auth',
			                    'defaults' => array(
			                        '__NAMESPACE__' => 'Auth\Controller',
			                        'controller'    => 'Index',
			                        'action'        => 'index',
			                    ),
			                ),
			                'may_terminate' => true,
			                'child_routes' => array(
			                    'default' => array(
			                        'type'    => 'Segment',
			                        'options' => array(
			                            'route'    => '/[:controller[/:action[/:id]]]',
			                            'constraints' => array(
			                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
											'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
											'id'     	 => '[a-zA-Z0-9_-]*'
			                            ),
			                            'defaults' => array(
			                            ),
			                        ),
			                    ),
			                ),
			            ),
				),
		),
		'service_manager' => array(
				'abstract_factories' => array(
						'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
						'Zend\Log\LoggerAbstractServiceFactory',
				),
				'aliases' => array(
						'translator' => 'MvcTranslator',
				),
		),
		'translator' => array(
				'locale' => 'es_ES',
				'translation_file_patterns' => array(
						array(
								'type'     => 'gettext',
								'base_dir' => __DIR__ . '/../language',
								'pattern'  => '%s.mo',
						),
				),
		),
		'controllers' => array(
				'invokables' => array(
						'Auth\Controller\Admin' => 'Auth\Controller\AdminController',
						'Auth\Controller\Auth'	=> 'Auth\Controller\AuthController',
						'Auth\Controller\Index'	=> 'Auth\Controller\IndexController'
						
				),
		),		
		'view_manager' => array(
				'template_path_stack' => array(
						'auth' => __DIR__ . '/../view'
				),
		
				'display_exceptions' => true,
		),
		// Placeholder for console routes
		'console' => array(
				'router' => array(
						'routes' => array(
						),
				),
		),
);