<?php

/**
 * Class Route
 *
 * @package             Pokemon\PokeAdmin\Guard
 * @author              Didier Youn <didier.youn@gmail.com>, Marc Intha-Amnouay <marc.inthaamnouay@gmail.com>, Antoine Renault <antoine.renault.mmi@gmail.com>
 * @copyright           Copyright (c) 2017 Tinwork
 * @license             http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link                https://github.com/Tinwork/ZendPokemon
 */
namespace Pokemon\PokeAdmin\Guard;

use Zend\Mvc\MvcEvent;
use Zend\ServiceManager\ServiceLocatorInterface;

use Pokemon\PokeAdmin\Exception\UnAuthorizedException;

class Route extends AbstractGuard
{
    /** @var ServiceLocatorInterface $serviceLocator */
    protected $serviceLocator;
    /**
     * Marker for invalid route errors
     */
    const ERROR = 'error-unauthorized-route';

    /**
     * Route constructor.
     *
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function __construct(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * Allow routes
     *
     * @param MvcEvent $event
     */
    public function onRoute(MvcEvent $event)
    {
        /** @var \Pokemon\PokeAdmin\Guard\Authorize $authorize */
        $authorize = $this->serviceLocator->get('PokeAdmin\Authorize');
        $match = $event->getRouteMatch();
        $routeName = $match->getMatchedRouteName();
        if ($authorize->isAllowed($event)) {
            return;
        }

        $event->setName(MvcEvent::EVENT_DISPATCH_ERROR);
        $event->setError(self::ERROR);
        $event->setParam('route', $routeName);
        $event->setParam('exception', new UnAuthorizedException('You are not authorized to access ' . $routeName));

        /** @var \Zend\Mvc\Application $app */
        $app = $event->getTarget();
        $app->getEventManager()->triggerEvent($event);
    }
}