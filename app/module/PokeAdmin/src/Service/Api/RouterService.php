<?php

/**
 * Class RouterService
 *
 * @package             PokeAdmin\Service\Api
 * @author              Didier Youn <didier.youn@gmail.com>, Marc Intha-Amnouay <marc.inthaamnouay@gmail.com>, Antoine Renault <antoine.renault.mmi@gmail.com>
 * @copyright           Copyright (c) 2017 Tinwork
 * @license             http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link                https://github.com/Tinwork/ZendPokemon
 */
namespace PokeAdmin\Service\Api;

class RouterService
{
    /** @var int HTTP_FLAG_UNAUTHORIZED */
    const HTTP_FLAG_UNAUTHORIZED = 401;
    /** @var int HTTP_FLAG_FORBIDDEN */
    const HTTP_FLAG_FORBIDDEN = 403;
    /** @var int HTTP_FLAG_METHOD_NOT_ALLOWED */
    const HTTP_FLAG_METHOD_NOT_ALLOWED = 405;

    public function reject(int $code)
    {
        return [
            "code"  => $code,
            "allowed" => false
        ];
    }

    public function forward(bool $oauth = true)
    {
        return [
            "code"      => 200,
            "allowed"   => true,
            "oauth"     => $oauth
        ];
    }
}
