<?php

/**
 * Class GeoServiceStrategy
 *
 * @package             Pokemon\PokeApi\Strategy
 * @author              Didier Youn <didier.youn@gmail.com>, Marc Intha-Amnouay <marc.inthaamnouay@gmail.com>, Antoine Renault <antoine.renault.mmi@gmail.com>
 * @copyright           Copyright (c) 2017 Tinwork
 * @license             http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link                https://github.com/Tinwork/ZendPokemon
 */
namespace Pokemon\PokeApi\Strategy;

use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;

use Pokemon\Common\Model\Resource\GeoPosition;
use Pokemon\Common\Strategy\AbstractRestApiServiceStrategy;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;

class GeoServiceStrategy extends AbstractRestApiServiceStrategy
{
    /** @var GeoPosition $resource */
    protected $resource;

    /**
     * TypeServiceStrategy constructor.
     *
     * @param GeoPosition $resource
     */
    public function __construct(GeoPosition $resource)
    {
        $this->resource = $resource;
    }

    /**
     * @param int $pokemonRank
     * @param string $position
     * @return array
     */
    public function savePosition(int $pokemonRank, string $position)
    {
        if (!$pokemonRank || !$this->format($position)) {
            $this->addError('Missing ID or missconfigured post data');
            return $this->__r();
        }
        /** @var array $position */
        $position = $this->format($position);
        if (!$this->isPokemonExist($pokemonRank)) {
            $this->addError(sprintf('The pokemon with rank %s doesnt exist in our database', $pokemonRank));
            return $this->__r();
        }
        $res = $this->resource->save($pokemonRank, $position);
        if (!$res) {
            $this->addError('Error when save pokemon to database');
            return $this->__r();
        }

        return $this->__r([
            'success' => 'The new location of pokemon have been saved'
        ]);
    }

    /**
     * @param array $positions
     */
    public function isAllowedPosition(array $positions)
    {

    }

    /**
     * @param int $rank
     * @return bool
     */
    private function isPokemonExist(int $rank) : bool
    {
        if (!isset($rank)) {
            return false;
        }
        $pokemon = $this->resource->load($rank, 'pokemons');

        return $pokemon ? true : false;
    }
}