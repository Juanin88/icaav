<?php

namespace Auth\Controller;

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Authentication\AuthenticationServiceInterface;
use Zend\View\Model\JsonModel;

class AuthController extends AbstractActionController {

	protected $authService;

    public function __construct(AuthenticationServiceInterface $authService) {
        $this->authService = $authService;
    }

	public function authenticationAction() {

		$user 	  = $this->params()->fromPost('user');
		$password = $this->params()->fromPost('password');
		$response = array();

		if(!empty($user) && !empty($password)) {
			$authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
			$adapter = $authService->getAdapter();
			$adapter->setIdentity($user);
			$adapter->setCredential($password);

			$authResult = $authService->authenticate();
			
			unset($_SESSION['Zend_Auth']);

			$response = array(
				'success'	=> $authResult->isValid()
				);
		}

		return new JsonModel($response);
	}

}
