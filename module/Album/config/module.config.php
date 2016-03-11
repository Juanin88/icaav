<?php
/**
 * Album Module Configuration.
 */
return array(
		'controllers' => array(
				'invokables' => array(
						'Album\Controller\Album' => 'Album\Controller\AlbumController',
						'Album\Controller\Index' => 'Album\Controller\IndexController',
				),
		),

		// The following section is new and should be added to your file
		'router' => array(
				'routes' => array(
						'album' => array(
								'type'    => 'segment',
								'options' => array(
										'route'    => '/album[/:action][/:id]',
										'constraints' => array(
												'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
												'id'     => '[0-9]+',
										),
										'defaults' => array(
												'controller' => 'Album\Controller\Album',
												'action'     => 'index',
										),
								),
								'may_terminate' => true,
								'child_routes' => array(
										'default' => array(
												'type'    => 'Segment',
												'options' => array(
														'route'    => '/[:controller[/:action]]',
														'constraints' => array(
																'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
																'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
														),
														'defaults' => array(
																'controller' => 'Application\Controller\Index',
																'action' => 'index'
														),
												),
										),
								),
						),
				),
		),

		'view_manager' => array(
				'template_path_stack' => array(
						'album' => __DIR__ . '/../view',
				),
		),

);



/**
 * Album Module
 * 
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
/*
return array(
		// The following section is new and should be added to your file
		'router' => array(
				'routes' => array(
						'album' => array(
								'type'    => 'segment',
								'options' => array(
										//'route'    => '/album[/:action][/:id]',
										'route'    => '/album/album/index',
										'constraints' => array(
												'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
												'id'     => '[0-9]+',
										),
										'defaults' => array(
												'controller' => 'Album\Controller\Album',
												'action'     => 'index',
										),
								),
						),
			            // The following is a route to simplify getting started creating
			            // new controllers and actions without needing to create a new
			            // module. Simply drop new controllers in, and you can access them
			            // using the path /application/:controller/:action
			            'album' => array(
			                'type'    => 'segment',
			                'options' => array(
			                    'route'    => '/',
			                   'defaults' => array(
			                        '__NAMESPACE__' => 'Album\Controller',
			                        'controller'    => 'Album',
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
			                            ),
			                            'defaults' => array(
			                           	 'controller' => 'Album\Controller\Album',
			                           	 'action' => 'index'
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
						'Album\Controller\Album' => 'Album\Controller\AlbumController',
						'Album\Controller\Index' => 'Album\Controller\IndexController',
				),
		),
		'view_manager' => array(
				'template_path_stack' => array(
						'album' => __DIR__ . '/../view'
				),
				'display_exceptions' => true,
		),
		'doctrine' => array(
		        'driver' => array(
		            'application_entities' => array(
		                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
		                'cache' => 'array',
		                'paths' => array(__DIR__ . '/../src/Album/Entity')
		            ),
		            'orm_default' => array(
		                'drivers' => array(
		                    'Album\Entity' => 'application_entities'
		                )
		        ))),
		// Placeholder for console routes
		'console' => array(
				'router' => array(
						'routes' => array(
						),
				),
		),
);*/