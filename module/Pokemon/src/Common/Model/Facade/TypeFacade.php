<?php

/**
 * Class TypeInterface
 *
 * @package             Pokemon\Common\Model\Facade
 * @author              Didier Youn <didier.youn@gmail.com>, Marc Intha-Amnouay <marc.inthaamnouay@gmail.com>, Antoine Renault <antoine.renault.mmi@gmail.com>
 * @copyright           Copyright (c) 2017 Tinwork
 * @license             http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link                https://github.com/Tinwork/ZendPokemon
 */
namespace Pokemon\Common\Model\Facade;

use Application\Repository\RepositoryInterface;

interface TypeFacade extends RepositoryInterface
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
    public function fetchAll() : array;

    /**
     * Fetch all types
     *
     * @param int $typeId
     * @param array|null $queries
     * @return array
     */
    public function fetchPokemonsByType(int $typeId, array $queries = null) : array;

    /**
     * Save type in database
     *
     * @param array $data
     * @return array
     * @throws \Exception
     */
    public function save(array $data) : array;

    /**
     * Update type by id
     *
     * @param int $typeId
     * @param array $data
     * @return bool
     */
    public function update(int $typeId, array $data) : bool;

    /**
     * Delete type by id
     *
     * @param int $typeId
     * @return bool
     */
    public function delete(int $typeId) : bool;
}