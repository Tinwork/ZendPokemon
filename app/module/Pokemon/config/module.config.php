<?php

/**
 * @package             Pokemon - Configuration
 * @author              Didier Youn <didier.youn@gmail.com>, Marc Intha-Amnouay <marc.inthaamnouay@gmail.com>, Antoine Renault <antoine.renault.mmi@gmail.com>
 * @copyright           Copyright (c) 2017 Tinwork
 * @license             http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link                https://github.com/Tinwork/ZendPokemon
 */
namespace Pokemon;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'guards' => [
        'restriction' => [
            'admin' => [
                'pattern' => '/^(?P<admin_pattern>\/admin\/.{1,})$/i',
                'routes' => [
                    '/admin/*'
                ]
            ]
        ],
        'whitelist' => [
            '/admin/oauth'
        ],
        'providers' => [
            'Pokemon\PokeAdmin\Guard\Route',
            'Pokemon\PokeAdmin\Guard\Controller'
        ],
        'template' => 'error/403',
    ],
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
                            'methods' => ['GET'],
                            'defaults' => [
                                'controller' => 'Pokemon\PokeAdmin\Controller\OAuthController',
                                'action' => 'auth'
                            ]
                        ]
                    ],
                    'pokemons' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/pokemons',
                            'methods' => ['GET', 'POST'],
                            'defaults' => [
                                'controller' => 'Pokemon\PokeAdmin\Controller\RestPokemonController',
                                'action' => 'preDispatch'
                            ]
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'rest' => [
                                'type' => Segment::class,
                                'options' => [
                                    'route' => '/[:id]',
                                    'methods' => ['PUT', 'PATCH', 'DELETE', 'GET'],
                                    'defaults' => [
                                        'controller' => 'Pokemon\PokeAdmin\Controller\RestPokemonController',
                                        'action' => 'preDispatch'
                                    ]
                                ]
                            ],
                        ]
                    ]
                ]
            ],
            'api' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/api'
                ],
                'child_routes' => [
                    'pokemons' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/pokemons',
                            'methods' => ['GET'],
                            'defaults' => [
                                'controller' => 'Pokemon\PokeApi\Controller\PokemonController',
                                'action' => 'show'
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ],
    'controllers' => [
        'factories' => [
            'Pokemon\PokeAdmin\Controller\OAuthController'          => 'Pokemon\PokeAdmin\Service\OAuthControllerFactory',
            'Pokemon\PokeAdmin\Controller\RestPokemonController'    => 'Pokemon\PokeAdmin\Service\RestPokemonControllerFactory',

            'Pokemon\PokeApi\Controller\PokemonController'          => 'Pokemon\PokeApi\Service\PokemonControllerFactory'
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
    ]
];