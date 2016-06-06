<?php 
namespace Facturacion\Controller;

use ReUse\Services\AbstractActionIcaavController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;


class OrigenVentaController1 extends AbstractActionIcaavController {

	public function __construct() {
		 parent::__construct();		 	
	}

protected function setSPs() {
	//insert
	 $this->setSP('sp_fac_i_origen_venta',array(
	 	array('method' => 'get','name' => 'pr_orig_ven'),
	 ),	array('@pr_affect_rows','@pr_message'), null, self::OUTS);
	 //update
	 $this->setSP('sp_fac_u_origen_venta',array(
	 	array('method' => 'get','name' => 'pr_id_orig'),
	 	array('method'=>'get','name'=>'pr_orig_ven'),
	 ), array('@pr_affect_rows','@pr_message'), null, self::OUTS);
	 //select
	 $this->setSP('sp_fac_c_origen_venta',array(
	 ), array('@pr_affect_rows','@pr_message'), null, self::ALL);
	 //delete
	 $this->setSP('sp_fac_d_origen_venta',array(
	 	array('method' =>'get','name' => 'pr_id_orig'),
	 ), array('@pr_affect_rows','@pr_message'), null, self::OUTS);

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