<?php

/**
 * Class PokemonController
 *
 * @package             Pokemon\PokeApi\Controller
 * @author              Didier Youn <didier.youn@gmail.com>, Marc Intha-Amnouay <marc.inthaamnouay@gmail.com>, Antoine Renault <antoine.renault.mmi@gmail.com>
 * @copyright           Copyright (c) 2017 Tinwork
 * @license             http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link                https://github.com/Tinwork/ZendPokemon
 */
namespace Pokemon\PokeApi\Controller;

use Pokemon\Common\Controller\AbstractController;
use Pokemon\PokeApi\Strategy\PokemonServiceStrategy;

class PokemonController extends AbstractController
{
    /** @var PokemonServiceStrategy*/
    protected $strategy;

    /**
     * PokemonController constructor.
     *
     * @param PokemonServiceStrategy $strategy
     */
    public function __construct(PokemonServiceStrategy $strategy)
    {
        $this->strategy = $strategy;
    }

    /**
     * Fetch all or fetch one pokemon collection
     *
     * @return \Zend\View\Model\JsonModel
     */
    public function showAction()
    {
        $pokemonId = $this->params()->fromRoute('id');
        $collection = $this->strategy->fetch($pokemonId);

        return $this->renderJson([
            'collection' => $collection
        ]);
    }
}