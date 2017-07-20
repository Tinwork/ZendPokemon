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

return [
    'guards' => [
        'restriction' => [
            'admin' => [
                'pattern' => '/^(?P<admin_pattern>\/admin[\/]?.{0,})$/i',
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
            'pokeroot' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => 'Pokemon\PokeDoc\Controller\IndexController',
                        'action' => 'index'
                    ]
                ],
            ],
            'admin' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/admin',
                    'methods' => ['GET'],
                    'defaults' => [
                        'controller' => 'Pokemon\PokeAdmin\Controller\AdminController',
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
                                'controller' => 'Pokemon\PokeAdmin\Controller\AdminController',
                                'action' => 'preDispatch'
                            ],
                            'constraints' => array(
                                'id' => '[\d]+',
                            )
                        ]
                    ],
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
                                    ],
                                    'constraints' => array(
                                        'id' => '[\d]+',
                                    )
                                ]
                            ],
                        ]
                    ],
                    'types' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/types',
                            'methods' => ['GET', 'POST'],
                            'defaults' => [
                                'controller' => 'Pokemon\PokeAdmin\Controller\TypeController',
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
                                        'controller' => 'Pokemon\PokeAdmin\Controller\TypeController',
                                        'action' => 'preDispatch'
                                    ],
                                    'constraints' => array(
                                        'id' => '[\d]+',
                                    )
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
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'rest' => [
                                'type' => Segment::class,
                                'options' => [
                                    'route' => '/[:id]',
                                    'methods' => ['GET'],
                                    'defaults' => [
                                        'controller' => 'Pokemon\PokeApi\Controller\PokemonController',
                                        'action' => 'show'
                                    ],
                                    'constraints' => array(
                                        'id' => '[\d]+',
                                    )
                                ]
                            ],
                        ]
                    ],
                    'types' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/types',
                            'methods' => ['GET'],
                            'defaults' => [
                                'controller' => 'Pokemon\PokeApi\Controller\TypeController',
                                'action' => 'show'
                            ]
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'rest' => [
                                'type' => Segment::class,
                                'options' => [
                                    'route' => '/[:id]',
                                    'methods' => ['GET'],
                                    'defaults' => [
                                        'controller' => 'Pokemon\PokeApi\Controller\TypeController',
                                        'action' => 'show'
                                    ],
                                    'constraints' => array(
                                        'id' => '[\d]+',
                                    )
                                ],
                                'may_terminate' => true,
                                'child_routes' => [
                                    'pokemons' => [
                                        'type' => Literal::class,
                                        'options' => [
                                            'route' => '/pokemons',
                                            'defaults' => [
                                                'controller' => 'Pokemon\PokeApi\Controller\TypeController',
                                                'action' => 'getPokemon'
                                            ]
                                        ]
                                    ],
                                ]
                            ],
                            'badges' => [
                                'type' => Literal::class,
                                'options' => [
                                    'route' => '/badges',
                                    'defaults' => [
                                        'controller' => 'Pokemon\PokeApi\Controller\TypeController',
                                        'action' => 'badge'
                                    ]
                                ]
                            ],
                        ]
                    ],
                    'geo' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/geo',
                            'methods' => ['GET'],
                            'defaults' => [
                                'controller' => 'Pokemon\PokeApi\Controller\GeoController',
                                'action' => 'show'
                            ]
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'geo_pokemon' => [
                                'type' => Literal::class,
                                'options' => [
                                    'route' => '/pokemons',
                                    'defaults' => [
                                        'controller' => 'Pokemon\PokeApi\Controller\GeoController',
                                        'action' => 'localisation'
                                    ]
                                ],
                                'may_terminate' => true,
                                'child_routes' => [
                                    'geo_pokemon_details' => [
                                        'type' => Segment::class,
                                        'options' => [
                                            'route' => '/[:id]',
                                            'defaults' => [
                                                'controller' => 'Pokemon\PokeApi\Controller\GeoController',
                                                'action' => 'localisation'
                                            ],
                                            'constraints' => array(
                                                'id' => '[\d]+',
                                            )
                                        ]
                                    ],
                                ]
                            ],
                        ]
                    ]
                ]
            ]
        ]
    ],
    'controllers' => [
        'factories' => [
            'Pokemon\PokeAdmin\Controller\OAuthController'          => 'Pokemon\PokeAdmin\Service\OAuthControllerFactory',
            'Pokemon\PokeAdmin\Controller\AdminController'          => 'Pokemon\PokeAdmin\Service\AdminControllerFactory',
            'Pokemon\PokeAdmin\Controller\TypeController'           => 'Pokemon\PokeAdmin\Service\TypeControllerFactory',
            'Pokemon\PokeAdmin\Controller\RestPokemonController'    => 'Pokemon\PokeAdmin\Service\RestPokemonControllerFactory',

            'Pokemon\PokeApi\Controller\PokemonController'          => 'Pokemon\PokeApi\Service\PokemonControllerFactory',
            'Pokemon\PokeApi\Controller\TypeController'             => 'Pokemon\PokeApi\Service\TypeControllerFactory',
            'Pokemon\PokeApi\Controller\GeoController'              => 'Pokemon\PokeApi\Service\GeoControllerFactory',

            'Pokemon\PokeDoc\Controller\IndexController'            => 'Pokemon\PokeDoc\Service\IndexControllerFactory'
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
        'strategies' => [
            'ViewJsonStrategy',
        ],
    ]
];
