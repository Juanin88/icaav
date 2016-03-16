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
	        'strategies' => array(
		        'ViewJsonStrategy',
		    ),
			'template_path_stack' => array(
					'auth' => __DIR__ . '/../view',
			),
		),


		'doctrine' => array(
	        'driver' => array(
	            'Index_Entities' => array(
	                'class' =>'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
	                'cache' => 'array',
	                'paths' => array(__DIR__ . '/../src/Index/Entity')
	            ),
	            'orm_default' => array(
	                'drivers' => array(
	                    'Index\Entity' => 'Index_Entities'
	                ),
	            ),
	        ),
	        
	        'authentication' => array(
	            'orm_default' => array(
	                'object_manager' => 'Doctrine\ORM\EntityManager',
	                'identity_class' => 'Index\Entity\User',
	                'identity_property' => 'usu_email',
	                'credential_property' => 'usu_password',
	                'credential_callable' => function(\Index\Entity\User $user, $passwordGiven) {

	                	return $passwordGiven == $user->getUsu_password();
	                	
	                    /* using Bcrypt 
	                    $bcrypt   = new \Zend\Crypt\Password\Bcrypt();
	                    $bcrypt->setSalt('m3s3Cr3tS4lty34h');
	                    // $passwordGiven is unhashed password that inputted by user
	                    // $user->getPassword() is hashed password that saved in db
	                    return $bcrypt->verify($passwordGiven, $user->getUsu_password());*/
	                },
	            ),
	        ),
	    ),
	    
	    'doctrine_factories' => array(
	        'authenticationadapter' => 'Index\Factory\Authentication\AdapterFactory',
	    ),
	    
	    'service_manager' => array(
	        'factories' => array(
	            'Zend\Authentication\AuthenticationService' => function($serviceManager) {
	                return $serviceManager->get('doctrine.authenticationservice.orm_default');
	            }
	        )  
	    ),
	    
	    'controllers' => array(
	        'factories' => array(
	            'Index\Controller\Auth' => function($controller) {
	                $authController = new \Index\Controller\AuthController($controller->getServiceLocator()->get('Zend\Authentication\AuthenticationService'));
	                return $authController;
	            },
	        ),
	    ),

);