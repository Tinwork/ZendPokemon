<?php

/**
 * @package             PokeAdmin - Configuration
 * @author              Didier Youn <didier.youn@gmail.com>, Marc Intha-Amnouay <marc.inthaamnouay@gmail.com>, Antoine Renault <antoine.renault.mmi@gmail.com>
 * @copyright           Copyright (c) 2017 Tinwork
 * @license             http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link                https://github.com/Tinwork/ZendPokemon
 */
namespace PokeAdmin;

use Zend\Router\Http\Literal;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'admin_pokemon_new' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/pokemon/new',
                    'defaults' => [
                        'controller' => Controller\Adminhtml\PokemonController::class,
                        'action'     => 'new',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\Adminhtml\IndexController::class => InvokableFactory::class,
            Controller\Adminhtml\PokemonController::class => InvokableFactory::class,
        ],
    ]
];
