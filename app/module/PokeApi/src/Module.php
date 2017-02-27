<?php

/**
 * Class Module
 *
 * @package             PokeApi - Configuration
 * @author              Didier Youn <didier.youn@gmail.com>, Marc Intha-Amnouay <marc.inthaamnouay@gmail.com>, Antoine Renault <antoine.renault.mmi@gmail.com>
 * @copyright           Copyright (c) 2017 Tinwork
 * @license             http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link                https://github.com/Tinwork/ZendPokemon
 */
namespace PokeApi;

class Module
{
    const VERSION = '3.0.1';

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
}