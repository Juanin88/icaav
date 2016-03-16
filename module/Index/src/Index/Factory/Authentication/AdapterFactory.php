<?php

namespace Index\Factory\Authentication;

use DoctrineModule\Service\Authentication\AdapterFactory as BaseAdapterFactory;
use Index\Adapter\ObjectRepository;
use Zend\ServiceManager\ServiceLocatorInterface;

class AdapterFactory extends BaseAdapterFactory {
    /**
     * {@inheritDoc}
     *
     * @return \Index\Adapter\ObjectRepository
     */
    public function createService(ServiceLocatorInterface $serviceLocator) {
        /* @var $options \DoctrineModule\Options\Authentication */
        $options = $this->getOptions($serviceLocator, 'authentication');
        if (is_string($objectManager = $options->getObjectManager())) {
            $options->setObjectManager($serviceLocator->get($objectManager));
        }
        return new ObjectRepository($options);
    }
}
