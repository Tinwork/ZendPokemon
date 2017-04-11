<?php

/**
 * Class UserInterface
 *
 * @package             Pokemon\Common\Model\Facade
 * @author              Didier Youn <didier.youn@gmail.com>, Marc Intha-Amnouay <marc.inthaamnouay@gmail.com>, Antoine Renault <antoine.renault.mmi@gmail.com>
 * @copyright           Copyright (c) 2017 Tinwork
 * @license             http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link                https://github.com/Tinwork/ZendPokemon
 */
namespace Pokemon\Common\Model\Facade;

use Application\Repository\RepositoryInterface;

interface UserFacade extends RepositoryInterface
{
    /**
     * Find user by username / password
     *
     * @param string $username
     * @param string $password
     * @return array|bool
     */
    public function find(string $username, string $password);

    /**
     * Create new user
     *
     * @param array $user
     * @return int
     */
    public function create(array $user) : int;

    /**
     * Update user
     *
     * @param int $userId
     * @param array $user
     * @return bool
     */
    public function update(int $userId, array $user) : bool;

    /**
     * Destroy user
     *
     * @param int $userId
     * @return int
     */
    public function destroy(int $userId) : int;

    /**
     * Get collection of administrators
     *
     * @return array
     */
    public function fetchAll() : array;
}