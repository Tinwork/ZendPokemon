<?php

/**
 * Class HttpService
 *
 * @package             PokeAdmin\Service\Api
 * @author              Didier Youn <didier.youn@gmail.com>, Marc Intha-Amnouay <marc.inthaamnouay@gmail.com>, Antoine Renault <antoine.renault.mmi@gmail.com>
 * @copyright           Copyright (c) 2017 Tinwork
 * @license             http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link                https://github.com/Tinwork/ZendPokemon
 */
namespace PokeAdmin\Service\Api;

use Zend\Http\PhpEnvironment\Request;

class HttpService
{
    /**
     * Check if request method is allowed in dispatch event
     *
     * @param string $method
     * @param array $allowedMethods
     * @return bool
     */
    public function validHttpMethod(string $method, array $allowedMethods) : bool
    {
        return in_array($method, $allowedMethods) ? true : false;
    }

    /**
     * Check if current route request need more validation or not
     *
     * @param Request $request
     * @param array $routesWhiteList
     * @return bool
     */
    public function routeIsWhiteList(Request $request, array $routesWhiteList) : bool
    {
        /** @var string $routeUriPath */
        $routeUriPath = $request->getUri()->getPath();

        return in_array($routeUriPath, $routesWhiteList) ? true : false;
    }

    public function validHttpMethodFromRoute(Request $request, array $routesConfig)
    {
        /** @var string $routeUriPath */
        $routeUriPath = $request->getUri()->getPath();
        /** @var string|bool $matchUrl */
        $matchUrl = $this->_matchUrl($routeUriPath, $routesConfig);
        if (!$matchUrl) {
            return false;
        }
        /** @var array $allowedMethods */
        $allowedMethods = isset($routesConfig[$matchUrl]["verbs"]) ? $routesConfig[$matchUrl]["verbs"] : false;
        if (!$allowedMethods || !in_array($request->getMethod(), $allowedMethods)) {
            return false;
        }

        return true;
    }

    protected function _matchUrl(string $requestRoute, array $routesConfig)
    {
        /** @var null $response */
        $response = null;
        /** @var array $url1 */
        $url1 = explode('/', $requestRoute);
        /** @var array $diff */
        $diff = [];
        foreach ($routesConfig as $routeUrl => $route) {
            $url2 = explode('/', $routeUrl);
            if (sizeof($url1) !== sizeof($url2)) {
                continue;
            }
            $diff[] = array_merge(array_diff($url2, $url1), array_diff($url1, $url2));
            $response = $routeUrl;
        }
        if (sizeof($diff) > 1 && !$this->_validDynamicUrlSegment($diff)) {
            return false;
        }

        return $response;
    }

    /**
     * Valid dynamic segment of url request
     *
     * @param array $urlDiff
     * @return bool
     */
    protected function _validDynamicUrlSegment(array $urlDiff) : bool
    {
        /** @var string $pattern */
        $pattern = "/(?P<dynamic_segment>^:[a-zA-Z]*)/i";
        foreach ($urlDiff as $segment) {
            if (!isset($segment[0]) || !isset($segment[1])) {
                return false;
            }
            preg_match($pattern, $segment[0], $matches);
            if (!isset($matches['dynamic_segment'])) {
                return false;
            }
        }

        return true;
    }
}
