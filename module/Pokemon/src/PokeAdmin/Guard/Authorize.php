<?php

/**
 * Class Authorize
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

class Authorize extends AbstractGuard
{
    /** @var ServiceLocatorInterface $serviceLocator */
    protected $serviceLocator;
    /** @var array $config */
    protected $config;

    /**
     * Authorize constructor.
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
     * Check if route is allowed to forward
     *
     * @param MvcEvent $event
     * @return bool
     */
    public function isAllowed(MvcEvent $event)
    {
        /** @var \Zend\Router\Http\RouteMatch $match */
        $match = $event->getRouteMatch();
        /** @var string $routeName */
        $routeName = $this->refactorRoutePattern($match->getMatchedRouteName());
        if ($this->isWhiteList($routeName)) {
            return true;
        }
        if (!$this->isProtectedRoutePattern($routeName)) {
            return true;
        }
        if ($this->isValidToken($event)) {
            return true;
        }

        return false;
    }

    /**
     * Check if current pattern route request is allowed to forward or not
     *
     * @param string $pattern
     * @return bool
     */
    public function isWhiteList(string $pattern) : bool
    {
        /** @var array $whiteList */
        $whiteList = $this->getWhiteListConfiguration();
        foreach ($whiteList as $allowedPattern) {
            if ($pattern !== $allowedPattern) {
                continue;
            }
            return true;
        }

        return false;
    }

    /**
     * Check if route need more check points
     *
     * @param string $requestPattern
     * @return bool
     */
    public function isProtectedRoutePattern(string $requestPattern) : bool
    {
        /** @var array $restrictedRoutes */
        $restrictedRoutes = $this->getRestrictedRoutesConfiguration();
        foreach ($restrictedRoutes as $prefixRoute => $protectedRoutes) {
            /** @var string $pattern */
            $pattern = $protectedRoutes['pattern'];
            /** @var string $groupPattern */
            $groupPattern = $prefixRoute . '_' . 'pattern';
            preg_match($pattern, $requestPattern, $matches);
            if (!isset($matches[$groupPattern]) || !$matches[$groupPattern]) {
                continue;
            }

            return true;
        }

        return false;
    }

    /**
     * Check JWT Token
     *
     * @param MvcEvent $event
     * @return bool
     */
    public function isValidToken(MvcEvent $event) : bool
    {
        /** @var \Zend\Http\PhpEnvironment\Request $request */
        $request = $event->getRequest();
        /** @var string|null $token */
        $token = $request->getQuery('token');
        /** @var \Pokemon\PokeAdmin\Strategy\OAuthServiceStrategy $service */
        $service = $this->serviceLocator->get('PokeAdmin\OAuth');
        if (!isset($token) || !$service->validateToken($token)) {
            return false;
        }

        return true;
    }

    /**
     * Add '/' to router pattern
     *
     * @param string $pattern
     * @return string
     */
    protected function refactorRoutePattern(string $pattern) : string
    {
        return '/' . $pattern;
    }
}