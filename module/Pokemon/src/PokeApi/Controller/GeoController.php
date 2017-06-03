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
use Pokemon\Common\Model\Entity\GeoPosition;
use Pokemon\PokeApi\Builder\Form\GeoPositionType;
use Pokemon\PokeApi\Builder\Validator\GeoPositionFormValidator;
use Pokemon\PokeApi\Strategy\GeoServiceStrategy;

class GeoController extends AbstractController
{
    /** @var GeoServiceStrategy $geoStrategy */
    protected $geoStrategy;

    /**
     * GeoController constructor.
     *
     * @param GeoServiceStrategy $strategy
     */
    public function __construct(GeoServiceStrategy $strategy)
    {
        $this->geoStrategy = $strategy;
    }

    public function showAction()
    {
        die('show');
    }

    /**
     * Add new localisation
     */
    public function localisationAction()
    {
        /** @var null $response */
        $response = null;
        /** @var int $pokemonId */
        $pokemonId = $this->params()->fromRoute('id');
        if ($this->request->isPost()) {
            /** @var string $data */
            $data = $this->params()->fromPost('data');
            /** @var GeoPositionType $geoPositionFormType */
            $geoPositionFormType = new GeoPositionType();
            $geoPosition = new GeoPosition();
            $geoPositionFormType->bind($geoPosition);
            $geoPositionFormType->setInputFilter(new GeoPositionFormValidator());
            $geoPositionFormType->setData($this->extractData($data));
            if ($geoPositionFormType->isValid()) {
                /** @var array $response */
                $response = $this->geoStrategy->savePosition($pokemonId, $data);
            } else {
                $this->geoStrategy->setErrors($this->getFormErrors($geoPositionFormType));
                $response = $this->geoStrategy->__r();
            }

            return $this->renderJson($response);
        }
        $longitude = $this->request->getQuery('long');
        $latitude = $this->request->getQuery('lat');
        $rayon = $this->request->getQuery('r');
        $response = $this->geoStrategy->radar($longitude, $latitude, $rayon, $pokemonId);

        return $this->renderJson($response);
    }
}