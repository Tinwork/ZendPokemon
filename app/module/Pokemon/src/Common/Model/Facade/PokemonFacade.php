<?php

/**
 * Class PokemonFacade
 *
 * @package             Pokemon\Common\Model\Facade
 * @author              Didier Youn <didier.youn@gmail.com>, Marc Intha-Amnouay <marc.inthaamnouay@gmail.com>, Antoine Renault <antoine.renault.mmi@gmail.com>
 * @copyright           Copyright (c) 2017 Tinwork
 * @license             http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link                https://github.com/Tinwork/ZendPokemon
 */
namespace Pokemon\Common\Model\Facade;

use Application\Repository\RepositoryInterface;

interface PokemonFacade extends RepositoryInterface
{
    /**
     * Save pokemon in database
     *
     * @param array $data
     * @return bool
     */
    public function save(array $data);
}