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

use Zend\ServiceManager\ServiceLocatorInterface;

abstract class AbstractGuard
{
    /** @var string GUARD_CONFIG_KEY */
    const GUARD_CONFIG_KEY = 'guards';
    /** @var ServiceLocatorInterface $serviceLocator */
    protected $serviceLocator;
    /** @var array $config */
    protected $config;


    /**
     * Get routes configuration
     *
     * @return array
     */
    protected function getRouteConfiguration() : array
    {
        return $this->config['router']['routes'];
    }

    /**
     * Get white list configuration
     *
     * @return array
     */
    protected function getWhiteListConfiguration() : array
    {
        return $this->config[self::GUARD_CONFIG_KEY]['whitelist'];
    }

    /**
     * Get white list configuration
     *
     * @return array
     */
    protected function getRestrictedRoutesConfiguration() : array
    {
        return $this->config[self::GUARD_CONFIG_KEY]['restriction'];
    }
}