<?php

/**
 * Class Pokemon
 *
 * @package             PokeAdmin\Model\Resource
 * @author              Didier Youn <didier.youn@gmail.com>, Marc Intha-Amnouay <marc.inthaamnouay@gmail.com>, Antoine Renault <antoine.renault.mmi@gmail.com>
 * @copyright           Copyright (c) 2017 Tinwork
 * @license             http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link                https://github.com/Tinwork/ZendPokemon
 */
namespace PokeAdmin\Model\Resource;

use PokeAdmin\Model\Resource\Facade\PokemonInterface;
use Zend\Db\Adapter\AdapterAwareTrait;

class Pokemon implements PokemonInterface
{
    use AdapterAwareTrait;

    /** @var \PokeAdmin\Model\Pokemon $pokemon */
    protected $pokemon;

    public function find()
    {
    }
}
