<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Icaav\Catalogs\Controllers;

use ReUse\Services\AbstractActionIcaavController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionIcaavController {

	public function __construct() {
		parent::__construct();
	}

	protected function setSPs() { }

    public function indexAction() {
    	$terminal = $this->params()->fromQuery('terminal');
        return (new ViewModel())->setTerminal($terminal);
    }

}
