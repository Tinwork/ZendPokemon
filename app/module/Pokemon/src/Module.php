<?php

/**
 * Class Module
 *
 * @package             PokeAdmin - Configuration
 * @author              Didier Youn <didier.youn@gmail.com>, Marc Intha-Amnouay <marc.inthaamnouay@gmail.com>, Antoine Renault <antoine.renault.mmi@gmail.com>
 * @copyright           Copyright (c) 2017 Tinwork
 * @license             http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link                https://github.com/Tinwork/ZendPokemon
 */
namespace Pokemon;

use Zend\Mvc\MvcEvent;
use Zend\Router\Http\RouteMatch;
use Zend\EventManager\EventInterface;

class Module
{
    /**
     * Init guards strategy
     *
     * @param EventInterface $event
     */
    public function onBootstrap(EventInterface $event)
    {
        /* @var \Zend\Mvc\ApplicationInterface $app*/
        $app = $event->getTarget();
        /* @var \Zend\ServiceManager\ServiceLocatorInterface $serviceManager*/
        $serviceManager = $app->getServiceManager();
        $strategy  = $serviceManager->get('PokeAdmin\Unauthorized');
        $guards = $serviceManager->get('PokeAdmin\Guards');

        $app->getEventManager()->attach(MvcEvent::EVENT_ROUTE, [$guards[0], 'onRoute'], -1000);
        $app->getEventManager()->attach(MvcEvent::EVENT_DISPATCH, [$guards[1], 'onDispatch'], -1000);
        $app->getEventManager()->attach(MvcEvent::EVENT_DISPATCH_ERROR, [$strategy, 'onDispatchError'], -5000);
    }

    /**
     * Get config
     *
     * @return array
     */
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    /**
     * Get service
     *
     * @return array
     */
    public function getServiceConfig()
    {
        return include __DIR__ . '/../config/service.config.php';
    }
}