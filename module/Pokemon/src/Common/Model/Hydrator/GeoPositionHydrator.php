<?php

/**
 * Class GeoPositionHydrator
 *
 * @package             Pokemon\Common\Model\Hydrator
 * @author              Didier Youn <didier.youn@gmail.com>, Marc Intha-Amnouay <marc.inthaamnouay@gmail.com>, Antoine Renault <antoine.renault.mmi@gmail.com>
 * @copyright           Copyright (c) 2017 Tinwork
 * @license             http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link                https://github.com/Tinwork/ZendPokemon
 */
namespace Pokemon\Common\Model\Hydrator;

use Pokemon\Common\Model\Entity\GeoPosition;
use Zend\Hydrator\HydratorInterface;

class GeoPositionHydrator implements HydratorInterface
{
    /**
     * @inheritdoc
     */
    public function extract($object)
    {
        if (!$object instanceof GeoPosition) {
            return [];
        }

        return [
            'longitude' => $object->getLongitude(),
            'latitude' => $object->getLatitude()
        ];
    }

    /**
     * @inheritdoc
     */
    public function hydrate(array $data, $object)
    {
        if (!$object instanceof GeoPosition) {
            return $object;
        }

        $object->setLongitude(isset($data['longitude']) ? (string)($data['longitude']) : null);
        $object->setLatitude(isset($data['latitude']) ? (string)($data['latitude']) : null);

        return $object;
    }
}