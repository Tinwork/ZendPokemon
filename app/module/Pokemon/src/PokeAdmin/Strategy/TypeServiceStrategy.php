<?php

/**
 * Class TypeServiceStrategy
 *
 * @package             Pokemon\PokeAdmin\Strategy
 * @author              Didier Youn <didier.youn@gmail.com>, Marc Intha-Amnouay <marc.inthaamnouay@gmail.com>, Antoine Renault <antoine.renault.mmi@gmail.com>
 * @copyright           Copyright (c) 2017 Tinwork
 * @license             http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link                https://github.com/Tinwork/ZendPokemon
 */
namespace Pokemon\PokeAdmin\Strategy;

use Zend\Db\Exception\ErrorException;
use Zend\Json\Json as Zend_Json;

use Pokemon\Common\Model\Resource\Type;
use Pokemon\Common\Strategy\AbstractRestApiServiceStrategy;

class TypeServiceStrategy extends AbstractRestApiServiceStrategy
{
    /** @var Type $model */
    protected $model;

    /**
     * TypeServiceStrategy constructor.
     *
     * @param Type $resource
     */
    public function __construct(Type $resource)
    {
        $this->model = $resource;
    }

    /**
     * Save new type in database
     *
     * @param string $data
     * @return array
     */
    public function save(string $data) : array
    {
        /** @var bool|array $data */
        $data = $this->format($data);
        if (!$data) {
            $this->addError("Trouble in POST data");
            return $this->__r();
        }
        var_dump($data); die;
        return [];
    }

    /**
     * Update type by identifier
     *
     * @param int $typeId
     * @param string $data
     * @return array
     */
    public function update(int $typeId, string $data) : array
    {
        return [];
    }

    /**
     * Delete type by identifier
     *
     * @param int $typeId
     * @return array
     */
    public function delete(int $typeId) : array
    {
        return [];
    }
}