<?php

namespace ReUse\Services;

use DoctrineORMModule\Form\Element\DoctrineEntity;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\EntityManager;
use Zend\Mvc\Controller\AbstractActionController;

abstract class AbstractActionIcaavController extends AbstractActionController {
	
	/**
	 * @var EntityManager
	 */
	protected $entityManager;
	
	/**
	 * Sets the EntityManager
	 *
	 * @param EntityManager $em
	 * @access protected
	 * @return PostController
	 */
	protected function setEntityManager(EntityManager $em)
	{
		$this->entityManager = $em;
		return $this;
	}
	
	/**
	 * Returns the EntityManager
	 *
	 * Fetches the EntityManager from ServiceLocator if it has not been initiated
	 * and then returns it
	 *
	 * @access protected
	 * @return EntityManager
	 */
	protected function getEntityManager()
	{
		if (null === $this->entityManager) {
			$this->setEntityManager($this->getServiceLocator()->get('Doctrine\ORM\EntityManager'));
		}
		return $this->entityManager;
	}

	/**
	 * 
	 * @param unknown $nameSP
	 * @param array $params
	 */
	public function callSP ( $nameSP , array $params ){
		$em = $this->getEntityManager();
		//Assume that you have connected to a database instance...
		$statement = $em->getConnection();
		$results = $statement->executeQuery("CALL {$nameSP}(".implode(',', array_fill(0, count($params), '?')).");", $params);

		$album = $results->fetchAll();

		return $album;
	}

}
