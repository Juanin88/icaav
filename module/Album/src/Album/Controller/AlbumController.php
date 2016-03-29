<?php
namespace Album\Controller;

use Album\Entity\Album;
use Album\Model\AlbumModel;       
use Album\Form\AlbumForm;
use Zend\View\Model\JsonModel;
use ReUse\Services\AbstractActionIcaavController;

class AlbumController extends AbstractActionIcaavController {
	
	public function __construct() {
		parent::__construct();
	}

	protected function setSPs() {
		$this->setSP('update_album', array(
				array('method' => 'post', 'name' => 'id_album'),
				array('method' => 'post', 'name' => 'artist'),
				array('method' => 'post', 'name' => 'title'),
			), null, new AlbumForm());
		$this->setSP('delete_album', array(
				array('method' => 'route', 'name' => 'id'),
			));
	}
	
	public function indexAction() {
		$repository = $this->getEntityManager()->getRepository('Album\Entity\Album');
		$albums     = $repository->findAll();
		
		return array('albums'=>$albums);
	}

	public function addAction() {
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
				return $this->redirect()->toRoute('album', array('controller' => 'album', 'action' => 'index'));
			}
		}
		return array('form' => $form);
	}

	public function editAction() {
		$id = (int) $this->params()->fromRoute('id', 0);
		
		if (!$id) {
			$id = $this->getRequest()->getPost('id_album',null);
		}

		$album = $this->callSimpleSP('select_album', array($id));

		$form = new AlbumForm();
		$form->populateValues($album[0]);
		$form->get('submit')->setAttribute('value', 'Edit');

		$request = $this->getRequest();
		if ($request->isPost()) {

			$form->setData($request->getPost());
	
				$this->callSPByName('update_album');
			if ($form->isValid()) {
				
				return $this->redirect()->toRoute('album', array('controller' => 'album', 'action' => 'index'));
			}
		} 
		return array(
				'id_album' => $id,
				'form' => $form);
		
	}

	public function deleteAction() {
		$id = (int) $this->params()->fromRoute('id', 0);
		if (!$id) {
			return $this->redirect()->toRoute('album');
		}

		$album = $this->callSimpleSP('select_album', array($id));
		
		$request = $this->getRequest();
		if ($request->isPost()) {
			$del = $request->getPost('del', 'No');
		
			if ($del == 'Yes') {
				$album = $this->callSPByName('delete_album');
			}
			// Redirect to list of albums
			return $this->redirect()->toRoute('album', array('controller' =>'album','action' => 'index'));
		}
		
		return array(
				'id'    => $id,
				'album' => $album[0]
		);
	}
}