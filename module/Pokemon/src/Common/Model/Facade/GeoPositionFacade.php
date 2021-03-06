<?php

/**
 * Class GeoPositionFacade
 *
 * @package             Pokemon\Common\Model\Facade
 * @author              Didier Youn <didier.youn@gmail.com>, Marc Intha-Amnouay <marc.inthaamnouay@gmail.com>, Antoine Renault <antoine.renault.mmi@gmail.com>
 * @copyright           Copyright (c) 2017 Tinwork
 * @license             http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link                https://github.com/Tinwork/ZendPokemon
 */
namespace Pokemon\Common\Model\Facade;

use Application\Repository\RepositoryInterface;

interface GeoPositionFacade extends RepositoryInterface
{
    /**
     * Fetch one or all type
     *
     * @param int $typeId
     * @return array
     */
    public function fetch(int $typeId) : array;

    /**
     * Fetch one type
     *
     * @param int $typeId
     * @return array
     */
    public function fetchOne(int $typeId) : array;

    /**
     * Fetch all types
     *
     * @return array
     */
    public function fetchAll();

    /**
     * Save new location in database
     *
     * @param int $pokemonId
     * @param array $data
     * @return array
     * @throws \Exception
     */
    public function save(int $pokemonId, array $data) : array;


    /**
     * Delete type by id
     *
     * @param int $typeId
     * @return bool
     */
    public function delete(int $typeId) : bool;
}