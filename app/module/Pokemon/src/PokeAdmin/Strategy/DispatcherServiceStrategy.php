<?php

/**
 * Class DispatcherServiceStrategy
 *
 * @package             Pokemon\PokeAdmin\Strategy
 * @author              Didier Youn <didier.youn@gmail.com>, Marc Intha-Amnouay <marc.inthaamnouay@gmail.com>, Antoine Renault <antoine.renault.mmi@gmail.com>
 * @copyright           Copyright (c) 2017 Tinwork
 * @license             http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link                https://github.com/Tinwork/ZendPokemon
 */
namespace Pokemon\PokeAdmin\Strategy;

use Pokemon\PokeAdmin\Exception\UnAuthorizedException;
use Pokemon\PokeAdmin\Guard\Controller;
use Zend\Http\PhpEnvironment\Request;
use Zend\Mvc\MvcEvent;
use Zend\ServiceManager\ServiceLocatorInterface;

class DispatcherServiceStrategy
{
    /** @var ServiceLocatorInterface $serviceLocator */
    protected $serviceLocator;
    /** @var array $config */
    protected $config;
    /** @var array REST_ACTIONS */
    const REST_ACTIONS = [
        'POST'      => 'new',
        'PUT'       => 'edit',
        'DELETE'    => 'delete',
        'GET'       => 'show'
    ];

    /**
     * DispatcherServiceStrategy constructor.
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @param array $config
     */
    public function __construct(ServiceLocatorInterface $serviceLocator, array $config)
    {
        $this->serviceLocator = $serviceLocator;
        $this->config = $config;
    }

    /**
     * Dispatch route to the target HTTP method
     *
     * @param MvcEvent $event
     * @return bool|string
     */
    public function dispatchRoute(MvcEvent $event)
    {
        /** @var string $restAction */
        $restAction = $this->permuteActionByHttpMethod($event);
        if (!$restAction) {
            return false;
        }

        return $restAction;
    }

    /**
     * Trigger dispatch error
     *
     * @param MvcEvent $event
     * @return object
     */
    public function triggerDispatchError(MvcEvent $event)
    {
        $match = $event->getRouteMatch();
        $routeName = $match->getMatchedRouteName();

        $event->setName(MvcEvent::EVENT_DISPATCH_ERROR);
        $event->setError(Controller::ERROR);
        $event->setParam('route', $routeName);
        $event->setParam('exception', new UnAuthorizedException('You are not authorized to access ' . $routeName));

        $event->getApplication()->getEventManager()->triggerEvent($event);
        $event->stopPropagation(true);

        return $event->getResult();
    }

    /**
     * Permute controllers actions by HTTP methods
     *
     * @param MvcEvent $event
     * @return string
     */
    protected function permuteActionByHttpMethod(MvcEvent $event) : string
    {
        /** @var Request $request */
        $request = $event->getRequest();
        /** @var string $requestMethod */
        $requestMethod = $request->getMethod();
        if (!isset($this::REST_ACTIONS[$requestMethod])) {
            return false;
        }

        return self::REST_ACTIONS[$requestMethod];
    }
}