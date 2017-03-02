<?php

/**
 * Class Http
 *
 * @package             TinworkApiConnector\Helper
 * @author              Didier Youn <didier.youn@gmail.com>, Marc Intha-Amnouay <marc.inthaamnouay@gmail.com>, Antoine Renault <antoine.renault.mmi@gmail.com>
 * @copyright           Copyright (c) 2017 Tinwork
 * @license             http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link                https://github.com/Tinwork/ZendPokemon
 */
namespace TinworkApiConnector\Helper;

class Http
{
    /**
     * Check if request method is allowed in dispatch event
     *
     * @param string $method
     * @param array $allowedMethods
     * @return bool
     */
    public function validateMethod(string $method, array $allowedMethods) : bool
    {
        return in_array($method, $allowedMethods) ? true : false;
    }
}
