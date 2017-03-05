<?php

/**
 * Class DispatcherService
 *
 * @package             PokeAdmin\Service\Api
 * @author              Didier Youn <didier.youn@gmail.com>, Marc Intha-Amnouay <marc.inthaamnouay@gmail.com>, Antoine Renault <antoine.renault.mmi@gmail.com>
 * @copyright           Copyright (c) 2017 Tinwork
 * @license             http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link                https://github.com/Tinwork/ZendPokemon
 */
namespace PokeAdmin\Service\Api;

use Zend\Http\PhpEnvironment\Request;

class DispatcherService
{
    /** @var RouterService $router */
    private $router = null;
    /** @var HttpService $http */
    private $http = null;

    /**
     * Request constructor.
     *
     * @param HttpService $http
     * @param RouterService $router
     */
    public function __construct(HttpService $http, RouterService $router)
    {
        $this->http = $http;
        $this->router = $router;
    }

    /**
     * Check if current current can process or not
     *
     * @param Request $request
     * @param array $config
     * @return null|array|bool
     */
    public function process(Request $request, array $config)
    {
        /** @var string $method */
        $method = $request->getMethod();
        if (!$this->http->validHttpMethod($method, $config['methods'])) {
            return $this->router->reject(RouterService::HTTP_FLAG_METHOD_NOT_ALLOWED);
        }
        if ($this->http->routeIsWhiteList($request, $config['routes']['whitelist'])) {
            return $this->router->forward(false);
        }
        if (!$this->http->validHttpMethodFromRoute($request, $config['routes']['protected'])) {
            return $this->router->reject(RouterService::HTTP_FLAG_METHOD_NOT_ALLOWED);
        }

        return $this->router->forward();
    }
}
