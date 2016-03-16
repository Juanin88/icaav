<?php
namespace Auth;
/**
 * Auth Module Configuration.
 */
 return array(

 		'controllers' => array(
 				'factories' => array(
		            'Auth\Controller\Auth' => function($controller) {
		                $authController = new \Auth\Controller\AuthController($controller->getServiceLocator()->get('Zend\Authentication\AuthenticationService'));
		                return $authController;
		            },
		        ),
 		),

		// The following section is new and should be added to your file
		'router' => array(
				'routes' => array(
						'auth' => array(
								'type'    => 'segment',
								'options' => array(
										'route'    => '/auth/:action[/:id]',
										'constraints' => array(
												'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
												'id'     => '[0-9]+',
										),
								),
						),
				),
		),

		'view_manager' => array(
			'display_not_found_reason' => false,
	        'display_exceptions'       => false,
	        'doctype'                  => 'HTML5',
	        'strategies' => array(
		        'ViewJsonStrategy',
		    ),
		),

		'doctrine' => array(
	        'driver' => array(
	            'Auth_Entities' => array(
	                'class' =>'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
	                'cache' => 'array',
	                'paths' => array(__DIR__ . '/../src/Auth/Entity')
	            ),
	            'orm_default' => array(
	                'drivers' => array(
	                    'Auth\Entity' => 'Auth_Entities'
	                ),
	            ),
	        ),
	        
	        'authentication' => array(
	            'orm_default' => array(
	                'object_manager' => 'Doctrine\ORM\EntityManager',
	                'identity_class' => 'Auth\Entity\User',
	                'identity_property' => 'usu_email',
	                'credential_property' => 'usu_password',
	                'credential_callable' => function(\Auth\Entity\User $user, $passwordGiven) {

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
	        'authenticationadapter' => 'Auth\Factory\Authentication\AdapterFactory',
	    ),
	    
	    'service_manager' => array(
	        'factories' => array(
	            'Zend\Authentication\AuthenticationService' => function($serviceManager) {
	                return $serviceManager->get('doctrine.authenticationservice.orm_default');
	            }
	        )  
	    ),

);