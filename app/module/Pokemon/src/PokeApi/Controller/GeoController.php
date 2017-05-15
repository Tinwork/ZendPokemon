<?php

/**
 * Class GeoController
 *
 * @package             Pokemon\PokeApi\Controller
 * @author              Didier Youn <didier.youn@gmail.com>, Marc Intha-Amnouay <marc.inthaamnouay@gmail.com>, Antoine Renault <antoine.renault.mmi@gmail.com>
 * @copyright           Copyright (c) 2017 Tinwork
 * @license             http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link                https://github.com/Tinwork/ZendPokemon
 */
namespace Pokemon\PokeApi\Controller;

use Pokemon\Common\Controller\AbstractController;
use Pokemon\PokeApi\Strategy\GeoServiceStrategy;

class GeoController extends AbstractController
{
    /** @var GeoServiceStrategy*/
    protected $strategy;

    /**
     * GeoController constructor.
     *
     * @param GeoServiceStrategy $strategy
     */
    public function __construct(GeoServiceStrategy $strategy)
    {
        $this->strategy = $strategy;
    }

    /**
     * Add new localisation
     */
    public function localisationAction()
    {
        /** @var int $pokemonId */
        $pokemonId = $this->params()->fromRoute('id');
        /** @var string $data */
        $data = $this->request->getContent();
        /** @var array $response */
        $response = $this->strategy->savePosition($pokemonId, $data);

        return $this->renderJson($response);
    }
}