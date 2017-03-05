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
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'admin' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/admin'
                ],
                'child_routes' => [
                    'oauth' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/oauth',
                            'defaults' => [
                                'controller' => Controller\OAuthController::class,
                                'action' => 'auth'
                            ]
                        ]
                    ],
                    'new' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/new',
                            'defaults' => [
                                'controller' => Controller\OAuthController::class,
                                'action' => 'new'
                            ]
                        ]
                    ],
                    'pokemon' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/pokemons',
                            'defaults' => [
                                'controller' => Controller\Api\PokemonController::class,
                                'action' => 'new',
                            ]
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'rest' => [
                                'type' => Segment::class,
                                'options' => [
                                    'route' => '/[:id]',
                                    'defaults' => [
                                        'controller' => Controller\Api\PokemonController::class,
                                        'action' => 'dispatch',
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            'PokeAdmin\Controller\OAuthController'        => 'PokeAdmin\Factory\OAuthControllerFactory',
            'PokeAdmin\Controller\Api\PokemonController'  => 'PokeAdmin\Factory\PokemonControllerFactory',
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
