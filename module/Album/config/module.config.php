<?php

namespace Album;

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
			                'type'    => 'Segment',
			                'options' => array(
			                    'route'    => '/[:module]',
			                    'defaults' => array(
			                        '__NAMESPACE__' => 'Album\Controller',
			                        'controller'    => 'Index',
			                        'action'        => 'index',
			                    ),
			                ),
			                'may_terminate' => true,
			                'child_routes' => array(
			                    'default' => array(
			                        'type'    => 'Segment',
			                        'options' => array(
			                            'route'    => '/[:controller[/:action[/:id]]][/]',
			                            'constraints' => array(
			                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
			                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
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
		'doctrine' => array(
	        'driver' => array(
	            __NAMESPACE__ . '_driver' => array(
	                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
	                'cache' => 'array',
	                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')
	            ),
	            'orm_default' => array(
	                'drivers' => array(
	                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
	                )
	            )
	        )
	    )
);
