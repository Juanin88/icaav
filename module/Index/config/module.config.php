<?php
namespace Index;
/**
 * Auth Module Configuration.
 */
 return array(

 		'controllers' => array(
 				'invokables' => array(
 						'Index\Controller\Index' => 'Index\Controller\IndexController',
 				),
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
					     )
				),
		),

		'view_manager' => array(
			'display_not_found_reason' => false,
	        'display_exceptions'       => false,
	        'doctype'                  => 'HTML5',
	        'not_found_template'       => 'error/404',
	        'exception_template'       => 'error/index',
	        'template_map' => array(
	            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
	            'auth/index/index' 		   => __DIR__ . '/../view/auth/index/index.phtml',
	            'error/404'                => __DIR__ . '/../view/error/404.phtml',
	            'error/index'              => __DIR__ . '/../view/error/index.phtml',
	        ),
	        'strategies' => array(
		        'ViewJsonStrategy',
		    ),
			'template_path_stack' => array(
					'auth' => __DIR__ . '/../view',
			),
		),

);