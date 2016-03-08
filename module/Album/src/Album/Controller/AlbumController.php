<?php
namespace Album\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Album\Entity\Album;
use DoctrineORMModule\Form\Element\DoctrineEntity;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\EntityManager;
use Album\Entity\Song;
use Album\Model\AlbumModel;       
use Album\Form\AlbumForm;   

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
		//echo '<pre>'.print_r($albums,true).'</pre>';die;
		
		return array('albums'=>$albums);
	}

	public function addAction()
	{
		
		
		$form = new AlbumForm();
		$form->get('submit')->setValue('Add');
		
		$request = $this->getRequest();
		
		
		
		if ($request->isPost()) {
			$albumModel = new AlbumModel();
			$form->setInputFilter($albumModel->getInputFilter());	
			$form->setData($request->getPost());

			if ($form->isValid()) {
				
				$albumModel->exchangeArray($form->getData());
				
				$objectManager = $this
				->getServiceLocator()
				->get('DoctrineORMEntityManager');
				
				$album = new Album();
				$album->setArtist($albumModel->artist);
				$album->setTitle($albumModel->title);
				
				$objectManager->persist($album);
				$objectManager->flush();
				// Redirect to list of albums
				return $this->redirect()->toRoute('album');
			}
		}
		return array('form' => $form);
		
		/*
		
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
		
		*/
	}

	public function editAction()
	{
		$params = $this->getRequest()->getPost();;
		echo '<pre>'.print_r($params,true).'</pre>';die;
		
		$id = (int) $this->params()->fromRoute('id', 0);
		$request = $this->getRequest();
		//echo '<pre>'.$request->getContent('id').'</pre>';die;
		if (!$id) {
			$request = $this->getRequest();
			$id = $request->getPost('id');
			if (!$id) {
				return $this->redirect()->toRoute('album', array(
						'action' => 'index'
				));
			}
		}
		
		$em = $this->getEntityManager();
		//Registry::set('entityManager', $em);
		
		$album = $em->find('Album\Entity\Album',$id);
		if (!$album) {
			
			return $this->redirect()->toRoute('album', array(
					'action' => 'index'
			));
		}
		
		$form = new AlbumForm();
		$request = $this->getRequest();
		$form->bind($album);
		$form->get('submit')->setAttribute('value', 'Edit');
		
		if ($request->isPost()) {
			$form->setData($request->getPost());
	
			if ($form->isValid()) {
				
				$em->persist($album);
				$em->flush();
				
				
				
			}
		} 
		
		return array(
				'id' => $id,
				'form' => $form);
		
	}

	public function deleteAction()
	{
	}
}