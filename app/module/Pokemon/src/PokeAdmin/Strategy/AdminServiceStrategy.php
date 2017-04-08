<?php

/**
 * Class AdminServiceStrategy
 *
 * @package             Pokemon\PokeAdmin\Strategy
 * @author              Didier Youn <didier.youn@gmail.com>, Marc Intha-Amnouay <marc.inthaamnouay@gmail.com>, Antoine Renault <antoine.renault.mmi@gmail.com>
 * @copyright           Copyright (c) 2017 Tinwork
 * @license             http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link                https://github.com/Tinwork/ZendPokemon
 */
namespace Pokemon\PokeAdmin\Strategy;

use Zend\Json\Json as Zend_Json;
use Pokemon\Common\Model\Resource\User;

class AdminServiceStrategy
{
    /** @var User $model */
    protected $model;
    /** @var array $config */
    protected $config;

    /**
     * AdminServiceStrategy constructor.
     *
     * @param User $model
     * @param array $config
     */
    public function __construct(User $model, array $config)
    {
        $this->model = $model;
        $this->config = $config;
    }

    /**
     * Create new administrator
     *
     * @param string $data
     * @return bool
     */
    public function createAdmin(string $data) : bool
    {
        if (!$data) {
            return false;
        }
        /** @var array $user */
        $user = Zend_Json::decode($data, true);
        /** @var bool $queryResult */
        return $this->model->create($user['body']);
    }

    /**
     * Delete admin by id
     *
     * @param int $userId
     * @return bool
     */
    public function deleteAdmin(int $userId) : bool
    {
        if (!$userId) {
            return false;
        }

        return $this->model->destroy($userId);
    }

    /**
     * Get all admins collection
     *
     * @return array
     */
    public function getCollection() : array
    {
        return $this->model->fetchAll();
    }

    /**
     * Get admin details by id
     *
     * @param int $userId
     * @return array
     */
    public function getAdmin(int $userId) : array
    {
       return $this->model->load($userId);
    }
}