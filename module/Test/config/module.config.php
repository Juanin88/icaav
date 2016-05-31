<?php

namespace Test;

/**
 * Test Module Configuration.
 */

return array(
		'controllers' => array(
				'invokables' => array(
						'Test\Controller\Index' => 'Test\Controller\IndexController',
				),
		),

		// The following section is new and should be added to your file
		'router' => array(
				'routes' => array(
						'Test' => array(
			                'type'    => 'Segment',
			                'options' => array(
			                    'route'    => '/test[/:controller][/:action][/:id]',
			                    'defaults' => array(
			                        '__NAMESPACE__' => 'Test\Controller',
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
						'test' => __DIR__ . '/../view',
				),
		),
		
);
