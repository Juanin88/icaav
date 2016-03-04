<?php
namespace Album\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Album\Entity\Album;
use DoctrineORMModule\Form\Element\DoctrineEntity;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\EntityManager;
use Album\Entity\Song;

class AlbumController extends AbstractActionController
{
	
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
	
	public function indexAction()
	{
		$repository = $this->getEntityManager()->getRepository('Album\Entity\Album');
		$albums     = $repository->findAll();
		
		$this->view->nombre = 'Juanito';
	}

	public function addAction()
	{
		$objectManager = $this
		->getServiceLocator()
		->get('DoctrineORMEntityManager');
		
		$album = new Album();
		$album->setArtist('Juanin');
		$album->setTitle('El mas mejor.');
		
		$objectManager->persist($album);
		$objectManager->flush();
		
		echo ('Hello there '.$album->getIdAlbum());

		$song = new Song();
		$song->setSongName('La celula que explota');
		$song->getIdAlbum(6);
		
		$objectManager->persist($song);
		$objectManager->flush();
		
		echo ('Hello there '.$song->getIdSong());
	}

	public function editAction()
	{
	}

	public function deleteAction()
	{
	}
}