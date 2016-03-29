<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
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
				array('method' => 'post', 'name' => 'active'),
			), array('@pr_affect_rows', '@pr_message'), new CorporativoForm());
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

}
