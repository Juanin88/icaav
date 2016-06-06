<?php

namespace Icaav;

/**
 * Icaav Module Configuration.
 */

return array(
		'controllers' => array(
				'invokables' => array(
						'Facturacion\Controller\Index' => 'Facturacion\Controller\IndexController',
						'Facturacion\Controller\Corporativo' => 'Facturacion\Controller\CorporativoController',
						'Facturacion\Controller\UnidadNegocio' => 'Facturacion\Controller\UnidadNegocioController',
						'Facturacion\Controller\OrigenVenta' => 'Facturacion\Controller\OrigenVentaController1'),
						'Icaav\Controller\Index' 			=> 'Icaav\Catalogs\Controllers\IndexController',
						'Icaav\Controller\Corporativo'  	=> 'Icaav\Catalogs\Controllers\CorporativoController',
						'Icaav\Controller\UnidadNegocio' 	=> 'Icaav\Catalogs\Controllers\UnidadNegocioController',
						'Icaav\Controller\OrigenVenta'		=> 'Icaav\Catalogs\Controllers\OrigenVentaController'
				),
		),
		// The following section is new and should be added to your file
		'router' => array(
				'routes' => array(
						'Icaav' => array(
			                'type'    => 'Segment',
			                'options' => array(
			                    'route'    => '/icaav[/:controller][/:action][/:id]',
			                    'defaults' => array(
			                        '__NAMESPACE__' => 'Icaav\Controller',
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
						'icaav' => __DIR__ . '/../view',
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
