<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Test\Controller;

use ReUse\Services\AbstractActionIcaavController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class IndexController extends AbstractActionIcaavController {

	public function __construct() {
		parent::__construct();
	}

	protected function setSPs() {
		$this->setSP('sp_fac_c_corporativo', array(
				array('method' => 'post', 'name' => 'pr_ini_pag'),
				array('method' => 'post', 'name' => 'pr_fin_pag')
			), array('@pr_affect_rows', '@pr_message'), null, self::ALL);
		
		$this ->setSP('sp_fac_d_corporativo', array(
				array('method'=> 'post', 'name'=>'pr_id_corp')
			), array('@pr_affect_rows', '@pr_message'), null, self::OUTS);
	}

    public function indexAction() { }

    public function getCorporativosAction() {
    	return new JsonModel($this->callSPByName('sp_fac_c_corporativo'));
    }

    public function deleteCorporativoAction() {
    	return new JsonModel($this->callSPByName('sp_fac_d_corporativo'));
    }

}
