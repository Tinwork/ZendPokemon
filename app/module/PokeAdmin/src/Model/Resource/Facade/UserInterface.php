<?php

/**
 * Class UserInterface
 *
 * @package             PokeAdmin\Model\Resource\Interface
 * @author              Didier Youn <didier.youn@gmail.com>, Marc Intha-Amnouay <marc.inthaamnouay@gmail.com>, Antoine Renault <antoine.renault.mmi@gmail.com>
 * @copyright           Copyright (c) 2017 Tinwork
 * @license             http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link                https://github.com/Tinwork/ZendPokemon
 */
namespace PokeAdmin\Model\Resource\Facade;

use Application\Repository\RepositoryInterface;

interface UserInterface extends RepositoryInterface
{
    /**
     * Find user by username / password
     *
     * @param string $username
     * @param string $password
     * @return bool
     */
    public function find(string $username, string $password);
}