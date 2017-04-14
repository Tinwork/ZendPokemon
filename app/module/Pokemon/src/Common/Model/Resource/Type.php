<?php

/**
 * Class Type
 *
 * @package             Pokemon\Common\Model\Resource
 * @author              Didier Youn <didier.youn@gmail.com>, Marc Intha-Amnouay <marc.inthaamnouay@gmail.com>, Antoine Renault <antoine.renault.mmi@gmail.com>
 * @copyright           Copyright (c) 2017 Tinwork
 * @license             http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link                https://github.com/Tinwork/ZendPokemon
 */
namespace Pokemon\Common\Model\Resource;

use Pokemon\Common\Model\Facade\TypeFacade;

use Zend\Db\Adapter\AdapterAwareTrait;

class Type implements TypeFacade
{
    use AdapterAwareTrait;

    /**
     * @inheritDoc
     */
    public function fetch(int $typeId): array
    {
        // TODO: Implement fetch() method.
    }

    /**
     * @inheritDoc
     */
    public function fetchOne(int $typeId): array
    {
        // TODO: Implement fetchOne() method.
    }

    /**
     * @inheritDoc
     */
    public function fetchAll()
    {
        // TODO: Implement fetchAll() method.
    }

    /**
     * @inheritDoc
     */
    public function save(array $data): bool
    {
        // TODO: Implement save() method.
    }

    /**
     * @inheritDoc
     */
    public function update(int $typeId, array $data): bool
    {
        // TODO: Implement update() method.
    }


}