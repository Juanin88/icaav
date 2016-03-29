<?php

namespace ReUse\Services;

use DoctrineORMModule\Form\Element\DoctrineEntity;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\EntityManager;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Form\Form;
use Zend\InputFilter\InputFilterAwareInterface;
use Album\Model\AlbumModel;

/**
*	This class will help to ActionControllers of Icaav providing a list of methods
*	that help make certain faster processes and serving as a guide for the proyect standardization
*
*	@author Alan Olivares, Juan Garfias
*/
abstract class AbstractActionIcaavController extends AbstractActionController {

	private $SPs = array();	
	
	/**
	 * @var EntityManager
	 */
	protected $entityManager;

	public function __construct() {
		$this->setSPs();
	}
	
	/**
	 * Sets the EntityManager
	 *
	 * @param EntityManager $em
	 * @access protected
	 * @return AbstractActionIcaavController
	 */
	protected function setEntityManager(EntityManager $em) {
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
	protected function getEntityManager() {
		return (!$this->entityManager) ?
				$this->
				setEntityManager(
					$this->getServiceLocator()->get('Doctrine\ORM\EntityManager')
				)->entityManager
				:
				$this->entityManager;
	}

	/**
	 * This method helps you run a sp. Just you want to say that sp execute
	 * and the parameters you need and get the result
	 * Example: callSimpleSP('my_sp', array('param1', 2, 'param3'));
	 *
	 * @author Alan Olivares, Juan Garfias
	 * @param {string} $nameSP
	 * @param array $params
	 */
	protected function callSimpleSP($nameSP , array $params) {
		$em = $this->getEntityManager();
		//Assume that you have connected to a database instance...
		$statement = $em->getConnection();
		$results = $statement->executeQuery("CALL {$nameSP}("
						 				.implode(',',
						 					array_fill(0,
						 						count($params),
						 						'?')
						 					). (($outputs) ? ','.implode(',', $outputs):'')
						 				.");",
										$params);
		return $results->fetchAll();
	}

	/**
	 * This method helps you run a sp. Just you want to say that sp execute
	 * and the parameters you need and get the result
	 * Example: callSP('my_sp', array(
	 *				'param1' => 'value1'
	 *				'param2' => 'value2'
	 *				), array('@output1', '@myOutPut2')
	 *			);
	 *
	 * @author Alan Olivares
	 * @param {string} $nameSP
	 * @param array $params
	 * @param array $outputs
	 */
	protected function callSP($nameSP , array $params, array $outputs = null){
		$em = $this->getEntityManager();

		$sql = "CALL {$nameSP}(:"
					.implode(',:',
	 					array_keys($params)
	 					).($outputs ? ','.implode(',', array_values($outputs)) : '')
	 				.");";
		try {
			$stmt = $em->getConnection()->prepare($sql);

			foreach ($params as $key => $param) {
				$stmt->bindParam(':'.$key, $params[$key]);
			}

			$stmt->execute();
			$dataCall = $stmt->fetchAll();
			$stmt->closeCursor();
		} catch(Exception $e) { return array('error', $e);}

		return $dataCall[0];
	}

	/**
	*	Having added a sp to the list with the method setSP () call you can send your sp
	*	Example:  callSPByName('my_sp');
	*
	*	@author Alan Olivares Ruiz
	*	@param {string} $nameSP
	*/
	protected function callSPByName($nameSP) {
		if (isset($this->SPs[$nameSP])) {
			$params = $this->getArrayParams($this->SPs[$nameSP]['dataParams']);
			$valid = true;

			if (
				$this->SPs[$nameSP]['form'] && 
				$this->SPs[$nameSP]['form'] instanceof Form
			) {
				$this->SPs[$nameSP]['form']->setData($params);
				$valid = $this->SPs[$nameSP]['form']->isValid();
			}

			return $valid ? $this->callSP($nameSP, $params, $this->SPs[$nameSP]['outputs']):
					array('errors' => $this->SPs[$nameSP]['form']->getMessages());
		}

		return array('error' => 'SP is not defined');
	}

	/**
	*	Parameters and methods post route are obtained.
	*	Depending on the description of each parameter
	*	Example: 
	*		array(
	*			array('method' => 'route', 'name' => 'id_album'),
	*			array('method' => 'get', 'name' => 'artist'),
	*			array('method' => 'post', 'name' => 'title'),
	*		)
	*	@author Alan Olivares Ruiz
	*	@param array $dataParams
	*/
	private function getArrayParams($dataParams) {
		$params = array();
		foreach ($dataParams as $dataParam) {
			$value = null;
			switch ($dataParam['method']) {
				case 'post':
					$value = $this->params()->fromPost($dataParam['name']);
					break;
				default:
					$value = $this->params()->fromQuery($dataParam['name']);
			}

			if(!empty($value)) {
				$params[$dataParam['name']] = $value;
			}
		}

		return $params;
	}

	/**
	*	Add a SP to list SPs
	*	Example:
	*	setSP('my_sp', array(
	*			array('method' => 'route', 'name' => 'id_album'),
	*			array('method' => 'get', 'name' => 'artist'),
	*			array('method' => 'post', 'name' => 'title'),
	*		), array('@output1', '@myOutPut2'), new MyFormZF2()
	*	);
	*	@author Alan Olivares
	*	@param {string} $nameSP
	*	@param array $dataParams
	*	@param Form $form
	*/
	protected function setSP($nameSP, array $dataParams, array $outputs = null, Form $form = null) {
		if(!empty($nameSP) && !empty($dataParams)) {
			$this->SPs[$nameSP] = array(
				'dataParams' => $dataParams,
				'outputs' => $outputs,
				'form' => $form,
				);
		}
	}

	protected abstract function setSPs();

}
