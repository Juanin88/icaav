<?php

namespace Facturacion\Controller;

use ReUse\Services\AbstractActionIcaavController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Facturacion\Forms\OrigenVentaForm;

class OrigenVentaController extends AbstractActionIcaavController {

	public function __construct() {
		parent::__construct();
	}

	protected function setSPs() {
		//SET INSERT SP
		$this->setSP('sp_fac_i_origen_venta', array(
			array('method' => 'post', 'name' => 'pr_id_orig'),
			array('method' => 'post', 'name' => 'pr_orig_ven'),
			array('method' => 'post', 'name' => 'pr_est_orig'),
			array('method' => 'post', 'name' => 'pr_fec_mod_ori','default' => 0,
					  'extra_operation_value' => function($active) {
							return $active == 'true' ? 1 : 0;
						}),
			), array('@pr_affect_rows', '@pr_message'), new OrigenVentaForm(), self::OUTS);
		// SET UPDATE SP
		$this->setSP('sp_fac_u_origen_venta', array(
			array('method' => 'post', 'name' => 'pr_id_orig'),
			array('method' => 'post', 'name' => 'pr_orig_ven'),
			array('method' => 'post', 'name' => 'pr_est_orig'),
			array('method' => 'post', 'name' => 'pr_fec_mod_ori','default' => 0,
					  'extra_operation_value' => function($active) {
							return $active == 'true' ? 1 : 0;
						}),
			), array('@pr_affect_rows', '@pr_message'), new OrigenVentaForm(), self::OUTS);

		// SET SELECT SP
		$this->setSP('sp_fac_c_origen_venta', array(
		), array('@pr_affect_rows','@pr_message'),   null, self::ALL);
 
		//SET DELETE SP
		$this->setSP('sp_fac_d_origen_venta', array(
				array('method' => 'post', 'name' => 'id_corporativo'),
		), array('@pr_affect_rows','@pr_message'),   null, self::OUTS);
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
