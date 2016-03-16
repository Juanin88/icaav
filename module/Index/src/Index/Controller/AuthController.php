<?php
namespace Index\Controller;

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

	public function indexAction() {
		return new JsonModel(array());
	}

	public function authenticationAction() {
		
		$user 	  = $this->params()->fromPost('user');
		$password = $this->params()->fromPost('password');

		$authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
		$adapter = $authService->getAdapter();
		$adapter->setIdentity($user);
		$adapter->setCredential($password);

		$authResult = $authService->authenticate();

		return new JsonModel(array(
			'success'	=> $authResult->isValid()
			));
	}

}
