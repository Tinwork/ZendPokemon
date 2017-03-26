<?php

/**
 * Class PokemonServiceStrategy
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

use Pokemon\Common\Model\Resource\Pokemon;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;

use Pokemon\PokeApi\Controller\PokemonController;

class PokemonServiceStrategy
{
    /** @var Pokemon $resource */
    protected $resource;

    /**
     * PokemonServiceStrategy constructor.
     *
     * @param Pokemon $resource
     */
    public function __construct(Pokemon $resource)
    {
        $this->resource = $resource;
    }


    public function fetch($pokemonId)
    {
        return $this->resource->fetch($pokemonId);
    }
}