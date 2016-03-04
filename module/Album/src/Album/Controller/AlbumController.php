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
	public function indexAction()
	{
		

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