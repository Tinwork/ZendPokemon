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
     * Fetch one or all pokemons
     *
     * @param int $pokemonId
     * @return array
     */
    public function fetch(int $pokemonId) : array;

    /**
     * Fetch one pokemon
     *
     * @param int $pokemonId
     * @return array
     */
    public function fetchOne(int $pokemonId) : array;

    /**
     * Fetch all pokemons
     *
     * @return array
     */
    public function fetchAll();

    /**
     * Save pokemon in database
     *
     * @param array $data
     * @param string $path
     * @return bool
     */
    public function save(array $data, string $path) : bool;

    /**
     * Update pokemon by id
     *
     * @param int $pokemonId
     * @param array $data
     * @return bool
     */
    public function update(int $pokemonId, array $data) : bool;

    /**
     * Delete pokemon
     *
     * @param int $pokemonId
     * @return bool
     */
    public function delete(int $pokemonId) : bool;
}