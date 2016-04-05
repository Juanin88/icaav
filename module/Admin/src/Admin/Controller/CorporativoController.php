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
		$this->setSP('sp_fac_i_corporativo', array(
				array('method' => 'post', 'name' => 'key'),
				array('method' => 'post', 'name' => 'name'),
				array('method' => 'post', 'name' => 'creditLimit'),
				array('method' => 'post', 'name' => 'active',
					  'default' => 1,
					  'extra_operation_value' => function($active) {
							return $active == 'true' ? 1 : 0;
						}),
			), array('@pr_affect_rows', '@pr_message'), new CorporativoForm(), self::OUTS);

		$this->setSP('sp_fac_c_corporativo', array(
				array('method' => 'post', 'name' => 'start_pag'),
				array('method' => 'post', 'name' => 'end_pag'),
			), array('@pr_affect_rows', '@pr_message'), null, self::ALL);

		$this->setSP('sp_fac_u_corporativo', array(
				array('method' => 'post', 'name' => 'new'),
				array('method' => 'post', 'name' => 'key'),
				array('method' => 'post', 'name' => 'name'),
				array('method' => 'post', 'name' => 'creditLimit'),
				array('method' => 'post', 'name' => 'active', 'default' => true,
					'extra_operation_value' => function($active) {
						return $active == 'true' ? 1 : 0;
					}),
			), array('@pr_affect_rows', '@pr_message'), null, self::ALL);
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

	public function getCorporativosAction() {
		return new JsonModel($this->callSPByName('sp_fac_c_corporativo'));
	}

}
