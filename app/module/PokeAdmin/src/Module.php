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
namespace PokeAdmin;

use Zend\Mvc\MvcEvent;
use Zend\Router\Http\RouteMatch;

use PokeAdmin\Service\Api\DispatcherService;
use PokeAdmin\Service\OAuthService;

class Module
{
    const VERSION = '3.0.1';

    /**
     * Dispatch after routes event
     *
     * @param MvcEvent $event
     */
    public function onBootstrap(MvcEvent $event)
    {
        $app = $event->getApplication();
        $em  = $app->getEventManager();

        $em->attach(MvcEvent::EVENT_ROUTE, [$this, 'canForward']);
    }

    /**
     * Check if the current request is available for forward
     *
     * @param MvcEvent $event
     * @return bool|void
     */
    public function canForward(MvcEvent $event)
    {
        $sm = $event->getApplication()->getServiceManager();
        /** @var \Zend\Router\Http\RouteMatch|bool $match */
        $match = $event->getRouteMatch();
        if (!$match instanceof RouteMatch) {
            return;
        }
        /** @var DispatcherService $dispatcher */
        $dispatcher = $sm->get('dispatcher.service');
        /** @var \Zend\Http\PhpEnvironment\Request $request */
        $request = $event->getRequest();
        /** @var array $config */
        $config = $this->getApiConfig();
        $forward = $dispatcher->process($request, $config);
        if (isset($forward) && $forward['allowed'] === true && $forward['oauth'] === false) {
            return;
        }
        /** @var OAuthService $oauth */
        $oauth = $sm->get('oauth.service');
        /** @var string $token */
        $token = $request->getQuery('oauth_token');
        if (!$token || !$oauth->validateToken($token)) {
            die('Not authorized');
        }

        return;
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
     * Get service config
     *
     * @return array
     */
    public function getServiceConfig()
    {
        return include __DIR__ . '/../config/service.config.php';
    }

    /**
     * Get api config
     *
     * @return array
     */
    public function getApiConfig()
    {
        return include __DIR__ . '/../config/api.config.php';
    }
}