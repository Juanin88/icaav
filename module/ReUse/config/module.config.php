<?php

namespace ReUse;

/**
 * Album Module Configuration.
 */

return array(
		'controllers' => array(
				'invokables' => array(
				),
		),
		'doctrine' => array(
	        'driver' => array(
	            __NAMESPACE__ . '_driver' => array(
	                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
	                'cache' => 'array',
	                'paths' => array(__DIR__ . '/../src/Entity')
	            ),
	            'orm_default' => array(
	                'drivers' => array(
	                    'Entity' => __NAMESPACE__ . '_driver'
	                )
	            )
	        )
	    )
);
