<?php

namespace Icaav\Catalogs\Controllers;

use ReUse\Services\AbstractActionIcaavController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Icaav\Catalogs\Forms\OrigenVentaForm;

class OrigenVentaController extends AbstractActionIcaavController {

	public function __construct() {
		parent::__construct();
	}

	protected function setSPs() {
		//SET INSERT SP
		$this->setSP('sp_fac_i_origen_venta', array(
			array('method' => 'post', 'name' => 'origen_venta'),
		 ), array('@pr_affect_rows', '@pr_message'), null, self::OUTS);
		// SET UPDATE SP
		$this->setSP('sp_fac_u_origen_venta', array(
			array('method' => 'post', 'name' => 'id_origen_venta'),
			array('method' => 'post', 'name' => 'origen_venta'),
		), array('@pr_affect_rows', '@pr_message'), null, self::OUTS);

		// SET SELECT SP
		$this->setSP('sp_fac_c_origen_venta', array(
		), array('@pr_affect_rows','@pr_message'),   null, self::ALL);
 
		//SET DELETE SP
		$this->setSP('sp_fac_d_origen_venta', array(
				array('method' => 'post', 'name' => 'pr_id_orig'),
		), array('@pr_affect_rows','@pr_message'),   null, self::OUTS);
	}
	
	public function indexAction() {
    	$terminal = $this->params()->fromQuery('terminal');
        return (new ViewModel())->setTerminal($terminal);
    }

	public function addOrigenVentaAction() {
		return new JsonModel($this->callSPByName('sp_fac_i_origen_venta'));
	}

	public function editOrigenVentaAction() {
		return new JsonModel($this->callSPByName('sp_fac_u_origen_venta'));
	}

	public function getOrigenVentaAction() {
		return new JsonModel($this->callSPByName('sp_fac_c_origen_venta'));
	}

	public function deleteOrigenVentaAction() {
		return new JsonModel($this->callSPByName('sp_fac_d_origen_venta'));
	}

}
