<?php
namespace Icaav\Catalogs\Controllers;

use ReUse\Services\AbstractActionIcaavController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Icaav\Catalogs\Forms\UnidadNegocioForm;

class UnidadNegocioController extends AbstractActionIcaavController {

	public function __construct() {
		parent::__construct();
	}

	protected function setSPs() {
		//SET INSERT SP
		$this->setSP('sp_fac_i_unidad_negocio', array(
			array('method' => 'post', 'name' => 'pr_unidad_neg'),
		 ), array('@pr_affect_rows', '@pr_message'), null, self::OUTS);
		// SET UPDATE SP
		$this->setSP('sp_fac_u_unidad_negocio', array(
			array('method' => 'post', 'name' => 'pr_id_uni_neg'),
			array('method' => 'post', 'name' => 'pr_unidad_neg'),
		), array('@pr_affect_rows', '@pr_message'), null, self::OUTS);

		// SET SELECT SP
		$this->setSP('sp_fac_c_unidad_negocio', array(
			array('method' => 'get', 'name' => 'pr_ini_pag', 'default' => 0),
			array('method' => 'get', 'name' => 'pr_fin_pag', 'default' => 10),
		), array('@pr_affect_rows','@pr_message'),   null, self::ALL);
 
		//SET DELETE SP
		$this->setSP('sp_fac_d_unidad_negocio', array(
				array('method' => 'post', 'name' => 'pr_id_uni_neg'),
		), array('@pr_affect_rows','@pr_message'),   null, self::OUTS);
	}
	
	public function indexAction() {
    	$terminal = $this->params()->fromQuery('terminal');
        return (new ViewModel())->setTerminal($terminal);
    }

	public function addUnidadNegocioAction() {
		return new JsonModel($this->callSPByName('sp_fac_i_unidad_negocio'));
	}

	public function editUnidadNegocioAction() {
		return new JsonModel($this->callSPByName('sp_fac_u_unidad_negocio'));
	}
	
	public function getUnidadNegocioAction() {
		return new JsonModel($this->callSPByName('sp_fac_c_unidad_negocio'));
	}
	
	public function deleteUnidadNegocioAction() {
		return new JsonModel($this->callSPByName('sp_fac_d_unidad_negocio'));
	}


}
