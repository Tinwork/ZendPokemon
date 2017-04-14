<?php

/**
 * @package             Pokemon - Configuration
 * @author              Didier Youn <didier.youn@gmail.com>, Marc Intha-Amnouay <marc.inthaamnouay@gmail.com>, Antoine Renault <antoine.renault.mmi@gmail.com>
 * @copyright           Copyright (c) 2017 Tinwork
 * @license             http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link                https://github.com/Tinwork/ZendPokemon
 */
namespace Pokemon;

use Zend\ServiceManager\ServiceManager;
use Zend\Db\Adapter\AdapterAwareInterface as AdapterAwareInterface;

return [
    'invokables' => [
        'Common\Resource\Pokemon'   => 'Pokemon\Common\Model\Resource\Pokemon',
        'Common\Resource\User'      => 'Pokemon\Common\Model\Resource\User',
        'Common\Resource\Type'      => 'Pokemon\Common\Model\Resource\Type'
    ],

    'factories' => [
        'Common\Config'             => 'Pokemon\Common\Service\ConfigServiceFactory',

        'PokeAdmin\OAuth'           => 'Pokemon\PokeAdmin\Service\OAuthServiceFactory',
        'PokeAdmin\Unauthorized'    => 'Pokemon\PokeAdmin\Service\UnauthorizedStrategyServiceFactory',
        'PokeAdmin\Guards'          => 'Pokemon\PokeAdmin\Service\GuardServiceFactory',
        'PokeAdmin\Authorize'       => 'Pokemon\PokeAdmin\Service\AuthorizeServiceFactory',
        'PokeAdmin\Pokemon'         => 'Pokemon\PokeAdmin\Service\PokemonServiceFactory',
        'PokeAdmin\Dispatcher'      => 'Pokemon\PokeAdmin\Service\DispatcherServiceFactory',
        'PokeAdmin\Admin'           => 'Pokemon\PokeAdmin\Service\AdminServiceFactory',
        'PokeAdmin\Type'            => 'Pokemon\PokeAdmin\Service\TypeServiceFactory',

        'PokeApi\Pokemon'           => 'Pokemon\PokeApi\Service\PokemonServiceFactory',
        'PokeApi\Type'              => 'Pokemon\PokeApi\Service\TypeServiceFactory',
        'PokeApi\Geo'               => 'Pokemon\PokeApi\Service\GeoServiceFactory'
    ],

    'initializers' => [
        function(ServiceManager $sm, $instance) {
            if ($instance instanceof AdapterAwareInterface) {
                $instance->setDbAdapter($sm->get('Zend\Db\Adapter\Adapter'));
            }
        }
    ]
];
