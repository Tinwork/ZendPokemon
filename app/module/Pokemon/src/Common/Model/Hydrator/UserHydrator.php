<?php

/**
 * Class UserHydrator
 *
 * @package             Pokemon\Common\Model\Hydrator
 * @author              Didier Youn <didier.youn@gmail.com>, Marc Intha-Amnouay <marc.inthaamnouay@gmail.com>, Antoine Renault <antoine.renault.mmi@gmail.com>
 * @copyright           Copyright (c) 2017 Tinwork
 * @license             http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link                https://github.com/Tinwork/ZendPokemon
 */
namespace Pokemon\Common\Model\Hydrator;

use Pokemon\Common\Model\Entity\User;
use Zend\Hydrator\HydratorInterface;

class UserHydrator implements HydratorInterface
{
    /**
     * @inheritdoc
     */
    public function extract($object)
    {
        if (!$object instanceof User) {
            return [];
        }

        return [
            'username' => $object->getUsername(),
            'password' => $object->getPassword(),
            'role' => $object->getRole()
        ];
    }

    /**
     * @inheritdoc
     */
    public function hydrate(array $data, $object)
    {
        if (!$object instanceof User) {
            return $object;
        }
        $object->setUsername(isset($data['username']) ? (string)($data['username']) : null);
        $object->setPassword(isset($data['password']) ? (string)($data['password']) : null);
        $object->setRole(isset($data['role']) ? (string)($data['role']) : null);

        return $object;
    }
}