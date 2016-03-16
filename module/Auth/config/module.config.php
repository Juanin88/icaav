<?php
/**
 * Auth Module Configuration.
 */
 return array(

 		'controllers' => array(
 				'invokables' => array(
 						'Auth\Controller\Index' => 'Auth\Controller\IndexController',
 						'Auth\Controller\Admin' => 'Auth\Controller\AdminController',
 						'Auth\Controller\Auth' => 'Auth\Controller\AuthController'
 				)
 		),
 			
		// The following section is new and should be added to your file
		'router' => array(
				'routes' => array(
						'auth' => array(
								'type'    => 'segment',
								'options' => array(
										'route'    => '/auth/[:controller[/:action]]',
										'constraints' => array(
												'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
												'id'     => '[0-9]+',
										),
										'defaults' => array(
												'controller' => 'Auth\Controller\Index',
												'action'     => 'index',
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
																'id'     	 => '[a-zA-Z0-9_-]*',
														),
														'defaults' => array(
														),
												),
										),
								),
								
								
								
						),
				),
		),

		'view_manager' => array(
			'display_not_found_reason' => true,
	        'display_exceptions'       => true,
	        'doctype'                  => 'HTML5',
	        'not_found_template'       => 'error/404',
	        'exception_template'       => 'error/index',
	        'template_map' => array(
	            'layoutAuth/layout'           => __DIR__ . '/../view/layoutAuth/layout.phtml',
	            'auth/index/index' 		   => __DIR__ . '/../view/auth/index/index.phtml',
	            'error/404'                => __DIR__ . '/../view/error/404.phtml',
	            'error/index'              => __DIR__ . '/../view/error/index.phtml',
	        ),
			'template_path_stack' => array(
					'auth' => __DIR__ . '/../view',
			),
		),

);