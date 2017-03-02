<?php

/**
 * Class Dispatcher
 *
 * @package             TinworkApiConnector\Helper
 * @author              Didier Youn <didier.youn@gmail.com>, Marc Intha-Amnouay <marc.inthaamnouay@gmail.com>, Antoine Renault <antoine.renault.mmi@gmail.com>
 * @copyright           Copyright (c) 2017 Tinwork
 * @license             http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link                https://github.com/Tinwork/ZendPokemon
 */
namespace TinworkApiConnector\Helper;

use Zend\Http\PhpEnvironment\Request;

class Dispatcher
{
    /** @var Router null  */
    private $router = null;
    /** @var Http null  */
    private $http = null;
    /** @var OAuth null  */
    private $oauth = null;

    /**
     * Request constructor.
     */
    public function __construct()
    {
        $this->router = $this->router ?? new Router();
        $this->http = $this->http ?? new Http();
        $this->oauth = $this->http ?? new OAuth();
    }

    /**
     * Check if current current can process or not
     *
     * @param Request $request
     * @param array $httpMethods
     * @param bool $oauth
     * @return null|array
     */
    public function process(Request $request, array $httpMethods, bool $oauth = false)
    {
        /** @var string $httpMethod */
        $httpMethod = $request->getMethod();
        if (!$this->http->validateMethod($httpMethod, $httpMethods)) {
            return $this->router->reject(Router::HTTP_FLAG_FORBIDDEN);
        }
        if ($oauth && !$this->oauth) {
            return $this->router->reject(Router::HTTP_FLAG_FORBIDDEN);
        }

        return $this->router->forward();
    }
}
