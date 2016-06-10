<?php

namespace Icaav\Catalogs\Controllers;

use ReUse\Services\AbstractActionIcaavController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Icaav\Catalogs\Forms\TipoProveedorForm;
/**
*
*/
class TipoProveedorController extends AbstractActionIcaavController {

	public function __construct() {
		parent::__construct();
	}

	protected function setSPs() {
		// SET INSERT SP
		$this->setSP('sp_fac_i_tipo_proveedor', array(
			array('method' => 'post', 'name' => 'tipo_proveedor'),
		 ), array('@pr_affect_rows', '@pr_message'), null, self::OUTS);
		// SET UPDATE SP
		$this->setSP('sp_fac_u_tipo_proveedor', array(
			array('method' => 'post', 'name' => 'id_tipo_proveedor'),
			array('method' => 'post', 'name' => 'tipo_proveedor'),
		), array('@pr_affect_rows', '@pr_message'), null, self::OUTS);

		// SET SELECT SP
		$this->setSP('sp_fac_c_tipo_proveedor', array(
			array('method' => 'post', 'name' => 'pr_ini_pag', 'default' => 0),
			array('method' => 'post', 'name' => 'pr_fin_pag', 'default' => 100),
		), array('@pr_affect_rows','@pr_message'),   null, self::ALL);
 
		//SET DELETE SP
		$this->setSP('sp_fac_d_tipo_proveedor', array(
				array('method' => 'post', 'name' => 'pr_id_tipo_proveedor'),
		), array('@pr_affect_rows','@pr_message'),   null, self::OUTS);
	}
	
	public function indexAction() {
    	$terminal = $this->params()->fromQuery('terminal');
        return (new ViewModel())->setTerminal($terminal);
    }

	public function addTipoProveedorAction() {
		return new JsonModel($this->callSPByName('sp_fac_i_tipo_proveedor'));
	}

	public function editTipoProveedorAction() {
		return new JsonModel($this->callSPByName('sp_fac_u_tipo_proveedor'));
	}
	
	public function getTipoProveedorAction() {
		return new JsonModel($this->callSPByName('sp_fac_c_tipo_proveedor'));
	}
	
	public function deleteTipoProveedorAction() {
		return new JsonModel($this->callSPByName('sp_fac_d_tipo_proveedor'));
	}


}
