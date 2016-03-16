<?php
namespace Index;
/**
 * Auth Module Configuration.
 */
 return array(

 		'controllers' => array(
 				'invokables' => array(
 						'Index\Controller\Index' => 'Index\Controller\IndexController',
 						'Index\Controller\Auth' => 'Index\Controller\AuthController',
 				)
 		),
 			
		// The following section is new and should be added to your file
		'router' => array(
				'routes' => array(
						'index' => array(
					         'type' => 'literal',
					         'options' => array(
					             'route'    => '/',
					             'defaults' => array(
					                 'controller' => 'Index\Controller\Index',
					                 'action'     => 'index',
					             ),
					         ),
					     ),
						'auth' => array(
								'type'    => 'segment',
								'options' => array(
										'route'    => '/auth[/][:action][/:id]',
										'constraints' => array(
												'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
												'id'     => '[0-9]+',
										),
										'defaults' => array(
												'controller' => 'Index\Controller\Auth',
												'action'     => 'index',
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
	            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
	            'auth/index/index' 		   => __DIR__ . '/../view/auth/index/index.phtml',
	            'error/404'                => __DIR__ . '/../view/error/404.phtml',
	            'error/index'              => __DIR__ . '/../view/error/index.phtml',
	        ),
			'template_path_stack' => array(
					'auth' => __DIR__ . '/../view',
			),
		),

);