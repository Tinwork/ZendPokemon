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
            'admin_auth' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/oauth',
                    'defaults' => [
                        'controller' => Controller\Adminhtml\AuthController::class,
                        'action'     => 'auth',
                    ],
                ],
            ],
            'admin_new_pokemon' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/pokemons/new',
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
            Controller\Adminhtml\AuthController::class => InvokableFactory::class,
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
        'strategies' => [
            'ViewJsonStrategy',
        ],
    ],
];
