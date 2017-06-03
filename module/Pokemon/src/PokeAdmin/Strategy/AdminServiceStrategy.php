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
use Pokemon\Common\Strategy\AbstractRestApiServiceStrategy;

class AdminServiceStrategy extends AbstractRestApiServiceStrategy
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
     * @return array
     */
    public function createAdmin(string $data) : array
    {
        if (!$data) {
            $this->addError('No data');
            return $this->__r();
        }
        /** @var array $user */
        $user = Zend_Json::decode($data, true);
        if (!isset($user['body'])) {
            $this->addError('Error in body parameters');
            return $this->__r();
        }
        /** @var int $lastInsertId */
        $lastInsertId = $this->model->create($user['body']);

        return $this->__r([
            "id" => $lastInsertId
        ]);
    }

    /**
     * Delete admin by id
     *
     * @param int $userId
     * @return array
     */
    public function deleteAdmin(int $userId) : array
    {
        if (!$userId) {
            $this->addError('Non determined id');

            return $this->__r();
        }
        try {
            /** @var int $affectedRow */
            $affectedRow = $this->model->destroy($userId);
            if (!$affectedRow || $affectedRow === 0) {
                $this->addError(sprintf('L\'admin dont l\'identifiant : %d n\'existe pas', $userId));
            }
        } catch (\Exception $e) {

        }
        return $this->__r();
    }

    /**
     * Get all admins collection
     *
     * @return array
     */
    public function getCollection() : array
    {
        /** @var array $admins */
        $admins = $this->model->fetchAll();
        if (!$admins) {
            $this->addWarning("Don\'t have any admins yet in database");
        }
        return $this->__r([
            'collection' => $admins
        ]);
    }

    /**
     * Get admin details by id
     *
     * @param int $userId
     * @return array
     */
    public function getAdmin(int $userId) : array
    {
        $admin = $this->model->load($userId);
        return $this->__r([
           'collection' => $admin
        ]);
    }
}