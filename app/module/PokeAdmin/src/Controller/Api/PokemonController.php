<?php

/**
 * Class PokemonController
 *
 * @package             PokeAdmin\Controller\Api
 * @author              Didier Youn <didier.youn@gmail.com>, Marc Intha-Amnouay <marc.inthaamnouay@gmail.com>, Antoine Renault <antoine.renault.mmi@gmail.com>
 * @copyright           Copyright (c) 2017 Tinwork
 * @license             http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link                https://github.com/Tinwork/ZendPokemon
 */
namespace PokeAdmin\Controller\Api;

use PokeAdmin\Service\Api\PokemonService;

class PokemonController extends DispatchController
{
    /** @var PokemonService $service */
    protected $service;

    /**
     * PokemonController constructor.
     *
     * @param PokemonService $service
     */
    public function __construct(PokemonService $service)
    {
        parent::__construct();

        $this->service = $service;
    }

    public function newAction()
    {
        var_dump($this->service);
        die("lol");
    }
}
