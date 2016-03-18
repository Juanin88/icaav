<?php
namespace Album\Controller;

use Album\Entity\Album;
use Album\Model\AlbumModel;       
use Album\Form\AlbumForm;   
use ReUse\Services\AbstractActionIcaavController;

class AlbumController extends AbstractActionIcaavController {
	
	public function __construct() {
		$this->setSPEdit('update_album', array());
		$this->setSPDelete('delete_album', array());
	}
	
	public function indexAction()
	{
		$repository = $this->getEntityManager()->getRepository('Album\Entity\Album');
		$albums     = $repository->findAll();
		
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
				return $this->redirect()->toRoute('album', array('controller' => 'album', 'action' => 'index'));
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

		$album = $this->callSP('select_album', array($id));
		
		$form = new AlbumForm();
		$form->populateValues($album[0]);
		$form->get('submit')->setAttribute('value', 'Edit');

		$request = $this->getRequest();
		if ($request->isPost()) {
			$form->setData($request->getPost());
	
			if ($form->isValid()) {
				$params = $this->getRequest()->getPost()->toArray();
				
				$album = $this->callSP('update_album', array($params['id_album'],$params['artist'],$params['title']));
				
				return $this->redirect()->toRoute('album', array('controller' =>'album','action' => 'index'
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

		$album = $this->callSP('select_album',array($id));
		
		$request = $this->getRequest();
		if ($request->isPost()) {
			$del = $request->getPost('del', 'No');
		
			if ($del == 'Yes') {
				

				$this->callSP('delete_album',array($id));
			}
			// Redirect to list of albums
			return $this->redirect()->toRoute('album', array('controller' =>'album','action' => 'index'
				));
		}
		
		return array(
				'id'    => $id,
				'album' => $album[0]
		);
	}
}