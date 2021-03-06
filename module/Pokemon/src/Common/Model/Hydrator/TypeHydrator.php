<?php

/**
 * Class TypeHydrator
 *
 * @package             Pokemon\Common\Model\Hydrator
 * @author              Didier Youn <didier.youn@gmail.com>, Marc Intha-Amnouay <marc.inthaamnouay@gmail.com>, Antoine Renault <antoine.renault.mmi@gmail.com>
 * @copyright           Copyright (c) 2017 Tinwork
 * @license             http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link                https://github.com/Tinwork/ZendPokemon
 */
namespace Pokemon\Common\Model\Hydrator;

use Pokemon\Common\Model\Entity\Type;
use Zend\Hydrator\HydratorInterface;

class TypeHydrator implements HydratorInterface
{
    /**
     * @inheritdoc
     */
    public function extract($object)
    {
        if (!$object instanceof Type) {
            return [];
        }

        return [
            'label' => $object->getLabel(),
            'color' => $object->getColor(),
            'badge' => $object->getBadge()
        ];
    }

    /**
     * @inheritdoc
     */
    public function hydrate(array $data, $object)
    {
        if (!$object instanceof Type) {
            return $object;
        }
        $object->setLabel(isset($data['label']) ? (string)($data['label']) : null);
        $object->setColor(isset($data['color']) ? (string)($data['color']) : null);
        $object->setBadge(isset($data['badge']) ? (string)($data['badge']) : null);

        return $object;
    }
}