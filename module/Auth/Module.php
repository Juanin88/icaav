<?php 
namespace Auth;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

class Module implements AutoloaderProviderInterface, ConfigProviderInterface
{
	/**
	 * Return an array for passing to Zend\Loader\AutoloaderFactory.
	 *
	 * @return array
	 */
	public function getAutoloaderConfig()
	{
		return array(
				'Zend\Loader\ClassMapAutoloader' => array(
						__DIR__ . '/autoload_classmap.php',
				),
				'Zend\Loader\StandardAutoloader' => array(
						'namespaces' => array(
	// Autoload all classes from namespace '<[NAMESPACE]>' from '/module/<[NAME_MODULE]>/src/<[NAME_MODULE]>'
								__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
						),
				),
		);
	}

	/**
	 * Returns configuration to merge with application configuration
	 *
	 * @return array|\Traversable
	 */
	public function getConfig()
	{
		return include __DIR__ . '/config/module.config.php';
	}
}