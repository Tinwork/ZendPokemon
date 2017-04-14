<?php

/**
 * Class TypeController
 *
 * @package             Pokemon\PokeApi\Controller
 * @author              Didier Youn <didier.youn@gmail.com>, Marc Intha-Amnouay <marc.inthaamnouay@gmail.com>, Antoine Renault <antoine.renault.mmi@gmail.com>
 * @copyright           Copyright (c) 2017 Tinwork
 * @license             http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link                https://github.com/Tinwork/ZendPokemon
 */
namespace Pokemon\PokeApi\Controller;

use Pokemon\Common\Controller\AbstractController;
use Pokemon\PokeApi\Strategy\TypeServiceStrategy;

class TypeController extends AbstractController
{
    /** @var TypeServiceStrategy*/
    protected $strategy;

    /**
     * TypeController constructor.
     *
     * @param TypeServiceStrategy $strategy
     */
    public function __construct(TypeServiceStrategy $strategy)
    {
        $this->strategy = $strategy;
    }

    public function showAction()
    {
        die('lol');
    }

    public function getPokemonAction()
    {
        $queryParams = $this->getRequest()->getQuery('query');
        $queryParams = explode(',', $queryParams);

        var_dump($queryParams); die;

        die('POKEMOOONS');
    }

}