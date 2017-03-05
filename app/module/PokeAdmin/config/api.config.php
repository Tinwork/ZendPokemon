<?php

/**
 * Class ${NAME}
 *
 * @author              Didier Youn <didier.youn@gmail.com>
 * @copyright           Copyright (c) 2017 DidYoun
 * @license             http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link                http://www.didier-youn.com
 */

return [
    'methods' => [
        'GET',
        'POST',
        'PUT',
        'DELETE',
        'PATCH'
    ],
    'routes' => [
        'whitelist' => [
            '/admin/oauth'
        ],
        'protected' => [
            '/admin/pokemons' => [
                'verbs' => [
                    'POST',
                    'GET'
                ]
            ],
            '/admin/pokemons/:id' => [
                'verbs' => [
                    'GET',
                    'PUT',
                    'DELETE'
                ]
            ],
        ]
    ],
];