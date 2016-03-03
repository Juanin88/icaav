<?php
namespace Album\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Album\Entity\Album;
use DoctrineORMModule\Form\Element\DoctrineEntity;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\EntityManager;

class AlbumController extends AbstractActionController
{
	public function indexAction()
	{
		
		$rsm = new ResultSetMapping();
		// build rsm here
		$entityManager = new \DoctrineORMModule\Options\EntityManager();
		$query = $entityManager->createNativeQuery('', $rsm);
		$query->setParameter(1, 'romanb');
		
		$users = $query->getResult();

	}

	public function addAction()
	{
		$objectManager = $this
		->getServiceLocator()
		->get('DoctrineORMEntityManager');
		
		$user = new Album();
		$user->setArtist('Juanin');
		$user->setTitle('El mas mejor.');
		
		$objectManager->persist($user);
		$objectManager->flush();
		
		die('Hello there '.$user->getId());
	}

	public function editAction()
	{
	}

	public function deleteAction()
	{
	}
}