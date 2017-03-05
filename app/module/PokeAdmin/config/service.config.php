<?php

/**
 * @package             PokeAdmin - Configuration
 * @author              Didier Youn <didier.youn@gmail.com>, Marc Intha-Amnouay <marc.inthaamnouay@gmail.com>, Antoine Renault <antoine.renault.mmi@gmail.com>
 * @copyright           Copyright (c) 2017 Tinwork
 * @license             http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link                https://github.com/Tinwork/ZendPokemon
 */
namespace PokeAdmin;

use Zend\ServiceManager\ServiceManager;
use Zend\Db\Adapter\AdapterAwareInterface as AdapterAwareInterface;

use PokeAdmin\Model\Resource\Pokemon;
use PokeAdmin\Model\Resource\Type;
use PokeAdmin\Model\Resource\User;

use PokeAdmin\Service\Api\RouterService;
use PokeAdmin\Service\Api\HttpService;

use PokeAdmin\Factory\OAuthServiceFactory;
use PokeAdmin\Factory\PokemonServiceFactory;
use PokeAdmin\Factory\DispatcherServiceFactory;

return [
    'invokables' => [
        'resource.pokemon'  => Pokemon::class,
        'resource.type'     => Type::class,
        'resource.user'     => User::class,

        'service.router'    => RouterService::class,
        'service.http'      => HttpService::class
    ],

    'factories' => [
        'oauth.service'         => OAuthServiceFactory::class,
        'pokemon.service'       => PokemonServiceFactory::class,
        'dispatcher.service'    => DispatcherServiceFactory::class
    ],

    'initializers' => [
        function(ServiceManager $sm, $instance) {
            if ($instance instanceof AdapterAwareInterface) {
                $instance->setDbAdapter($sm->get('Zend\Db\Adapter\Adapter'));
            }
        }
    ]
];
