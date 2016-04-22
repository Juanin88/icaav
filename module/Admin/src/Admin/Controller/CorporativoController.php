<?php

namespace Admin\Controller;

use ReUse\Services\AbstractActionIcaavController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Admin\Forms\CorporativoForm;
/**
*
* @author Alan Olivares
*/
class CorporativoController extends AbstractActionIcaavController {

	public function __construct() {
		parent::__construct();
	}

	protected function setSPs() {
		// SET INSERT SP
		$this->setSP('sp_fac_i_corporativo', array(
				array('method' => 'post', 'name' => 'nombre_corporativo'),
				array('method' => 'post', 'name' => 'limite_credito', 'default' => 0),
				array('method' => 'post', 'name' => 'estatus_corporativo',
					  'default' => 0,
					  'extra_operation_value' => function($active) {
							return $active == 'true' ? 1 : 0;
						}),
			), array('@pr_affect_rows', '@pr_message'), new CorporativoForm(), self::OUTS);
		// SET UPDATE SP
		$this->setSP('sp_fac_u_corporativo', array(
				array('method' => 'post', 'name' => 'id_corporativo'),
				array('method' => 'post', 'name' => 'nombre_corporativo'),
				array('method' => 'post', 'name' => 'limite_credito', 'default' => 0),
				array('method' => 'post', 'name' => 'estatus_corporativo',
					'extra_operation_value' => function($active) {
							return $active == 'true' ? 1 : 0;
						}),
			), array('@pr_affect_rows', '@pr_message'), new CorporativoForm(), self::OUTS);
		// SET SELECT SP
		$this->setSP('sp_fac_c_corporativo', array(
				array('method' => 'post', 'name' => 'start_pag'),
				array('method' => 'post', 'name' => 'end_pag'),
			), array('@pr_affect_rows', '@pr_message'), null, self::ALL);
		// SET DELETE SP
		$this->setSP('sp_fac_d_corporativo', array(
				array('method' => 'post', 'name' => 'id_corporativo'),
		), array('@pr_affect_rows', '@pr_message'), null, self::OUTS);
	}

	public function indexAction() {
		$terminal = $this->params()->fromQuery('terminal');
		return (new ViewModel())->setTerminal($terminal);
	}

	public function addAction() {
		$terminal = $this->params()->fromQuery('terminal');
		return (new ViewModel())->setTerminal($terminal);
	}

	public function addAjaxAction() {
		return new JsonModel($this->callSPByName('sp_fac_i_corporativo'));
	}

	public function editAjaxAction() {
		return new JsonModel($this->callSPByName('sp_fac_u_corporativo'));
	}
	
	public function deleteAjaxAction() {
		return new JsonModel($this->callSPByName('sp_fac_d_corporativo'));
	}

	public function getCorporativosAction() {
		return new JsonModel($this->callSPByName('sp_fac_c_corporativo'));
	}

}
