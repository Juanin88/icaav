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

	// VARIABLES FOR OPTIONS CALL SPs
	const CALL_ARRAY	= 1;
	const CALL_ASSOC	= 2;
	// VARIABLES FOR GET OPTIONS RESULT FROM QUERY
	const ONLY_RESULT 	= 1;
	const OUTS 			= 2;
	const ALL 			= 3;

	private 	$SPs 	= array();
	protected 	$entityManager;

	public function __construct() {
		$this->setSPs();
	}

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
	protected function callSimpleSP($nameSP, array $params, array $outs = null) {
		$em = $this->getEntityManager();
		//Assume that you have connected to a database instance...
		$statement = $em->getConnection();
		$sql = $this->getQueryCallSP($nameSP, $params, $outs, self::CALL_ARRAY);

		$results = $statement->executeQuery($sql, $params);

		return $results->fetchAll();
	}

	/**
	 * This method helps you run a sp. Just you want to say that sp execute
	 * and the parameters you need and get the result
	 * Example: callSP('my_sp', array(
	 *				'param1' => 'value1'
	 *				'param2' => 'value2'
	 *				), array('@out1', '@myOut2', self::ONLY_RESULT)
	 *			);
	 *
	 * @author Alan Olivares
	 * @param {string} $nameSP
	 * @param array $params
	 * @param array $outs
	 * @param int   $expectedResult -> posible values: contants in this class {ONLY_RESULT, OUTS, ALL}
	 */
	protected function callSP($nameSP , array $params, array $outs = null, $expectedResult){
		$dataOuts 	 = array();
		$dataCall 	 = array();
		$em			 = $this->getEntityManager();
		$sql		 = $this->getQueryCallSP($nameSP, $params, $outs, self::CALL_ASSOC);

		try {
			$connection = $em->getConnection();
			$stmt = $connection->prepare($sql);

			foreach ($params as $key => $param) {
				$stmt->bindParam(':'.$key, $params[$key]);
			}

			$execute = $stmt->execute();
			if($execute && ($expectedResult == self::ONLY_RESULT || $expectedResult == self::ALL)) {
				$dataCall = array('results' => $stmt->fetchAll());
				$stmt->closeCursor();
			}

			if($execute && ($expectedResult == self::OUTS || $expectedResult == self::ALL)) {
				$dataOuts = $this->getDataOuts($connection, $outs);
			}

		} catch(Exception $e) { return array('error', $e);}

		return array_merge($dataOuts, $dataCall);
	}

	private function getQueryCallSP($nameSP, array $params, array $outs = null, $optionCall) {

		return "CALL $nameSP("
				// Set params
				.$this->getParamsForCallSP($params, $optionCall)
				// Set outs if exist
				.($outs ? ','.implode(',', array_values($outs)) : '')
				.');';
	}

	private function getParamsForCallSP($params, $optionCall) {
		$paramsForCall = null;

		switch ($optionCall) {
			case self::CALL_ARRAY:
				$paramsForCall = implode(',',
						 		array_fill(0,
						 			count($params),
						 			'?'
						 		)
						 	);
				break;
			case self::CALL_ASSOC;
				$paramsForCall = ":"
						.implode(',:',
	 						array_keys($params)
	 					);
				break;
			default:
				throw new Exception("ERROR: Call option is not valid", 1);
		}

		return $paramsForCall;
	}

	private function getDataOuts($connection, $outs) {
		$query = 'SELECT '.implode(',', array_values($outs));
		$stmtOuts = $connection->prepare($query);
		$stmtOuts->execute();
		$dataOuts = $stmtOuts->fetch();
		$stmtOuts->closeCursor();

		return $dataOuts;
	}

	/**
	*	Having added a sp to the list with the method setSP () call you can send your sp
	*	Example:  callSPByName('my_sp');
	*
	*	@author Alan Olivares
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

			return $valid ? $this->callSP($nameSP, $params, $this->SPs[$nameSP]['outs'], $this->SPs[$nameSP]['expectedResult']):
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
	*	@author Alan Olivares
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
				case 'route':
					$value = $this->params()->fromRoute($dataParam['name']);
						break;
				default:
					$value = $this->params()->fromQuery($dataParam['name']);
			}

			if(is_numeric($value) || !empty($value)) {
				$params[$dataParam['name']] = 
						isset($dataParam['extra_operation_value']) &&
						is_callable($dataParam['extra_operation_value']) ?
							$dataParam['extra_operation_value']($value) : $value;
			} elseif(isset($dataParam['default'])) {
				$params[$dataParam['name']] = $dataParam['default'];
			}
		}
return array();
		return $params;
	}


	/**
	*	Add a SP to list SPs
	*	Example:
	*	setSP('my_sp', array(
	*			array('method' => 'route', 'name' => 'id_album'),
	*			array('method' => 'get', 'name' => 'artist'),
	*			array('method' => 'post', 'name' => 'title'),
	*		), array('@out1', '@myOut2'), new MyFormZF2(), self::ONLY_RESULT
	*	);
	*	@author Alan Olivares
	*	@param {string} $nameSP
	*	@param array $dataParams
	*	@param Form $form
	*	@param int $expectedResult -> posible values: contants in this class {ONLY_RESULT, OUTS, ALL}
	*/
	protected function setSP($nameSP, array $dataParams, array $outs = null, Form $form = null, $expectedResult = null) {
		if(!empty($nameSP) && !empty($dataParams)) {
			$this->SPs[$nameSP] = array(
				'dataParams'		=> $dataParams,
				'outs'				=> $outs,
				'form'				=> $form,
				'expectedResult'	=> $expectedResult,
			);
		}
	}

	/**
	* this method should take care to SETUP SPs
	**/
	protected abstract function setSPs();

}
