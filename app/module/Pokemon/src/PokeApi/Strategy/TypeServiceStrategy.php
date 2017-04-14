<?php

/**
 * Class TypeServiceStrategy
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

use Pokemon\Common\Model\Resource\Type;
use Pokemon\Common\Strategy\AbstractRestApiServiceStrategy;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;

use Pokemon\PokeApi\Controller\PokemonController;

class TypeServiceStrategy extends AbstractRestApiServiceStrategy
{
    /** @var Type $resource */
    protected $resource;

    /**
     * TypeServiceStrategy constructor.
     *
     * @param Type $resource
     */
    public function __construct(Type $resource)
    {
        $this->resource = $resource;
    }
}