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
use Auth\Services\DummyService;

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
		$dummy = new \Auth\Services\DummyService();echo $dummy->test(43);exit();
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
	}

	public function editAction()
	{
		$id = (int) $this->params()->fromRoute('id', 0);
		
		if (!$id) {
			$id = $this->getRequest()->getPost('id_album',null);
		}
		$em = $this->getEntityManager();
		//Assume that you have connected to a database instance...
		$statement = $em->getConnection();
		$results = $statement->executeQuery("CALL select_album(?);",array($id));
			
		$album = $results->fetchAll();
		unset($results);
		
		$form = new AlbumForm();
		$form->populateValues($album[0]);
		$form->get('submit')->setAttribute('value', 'Edit');

		$request = $this->getRequest();
		if ($request->isPost()) {
			$form->setData($request->getPost());
	
			if ($form->isValid()) {
				$params = $this->getRequest()->getPost()->toArray();
				$results = $statement->executeQuery("CALL update_album(?,?,?);",array($params['id_album'],$params['artist'],$params['title']));
				$album = $results->fetchAll();
				return $this->redirect()->toRoute('album', array(
						'action' => 'index'
				));
			}
		} 
		return array(
				'id_album' => $id,
				'form' => $form);
		
	}

	public function deleteAction()
	{
		$id = (int) $this->params()->fromRoute('id', 0);
		if (!$id) {
			return $this->redirect()->toRoute('album');
		}
		
		$em = $this->getEntityManager();
		//Assume that you have connected to a database instance...
		$statement = $em->getConnection();
		$results = $statement->executeQuery("CALL select_album(?);",array($id));
		$album = $results->fetchAll();
		unset($results);
		
		$request = $this->getRequest();
		if ($request->isPost()) {
			$del = $request->getPost('del', 'No');
		
			if ($del == 'Yes') {
				$em = $this->getEntityManager();
				//Assume that you have connected to a database instance...
				$statement = $em->getConnection();
				$results = $statement->executeQuery("CALL delete_album(?);",array($id));
				$album = $results->fetchAll();
				unset($results);
			}
		
			// Redirect to list of albums
			return $this->redirect()->toRoute('album');
		}
		
		return array(
				'id'    => $id,
				'album' => $album[0]
		);
	}
}