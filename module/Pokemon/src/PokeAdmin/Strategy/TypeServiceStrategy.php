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
        if ($this->verifyUniquesAttributes($this->model->getUniques(), $this->model, $data)) {
            return $this->__r();
        }
        /** @var array $response */
        $response = $this->model->save($data);

        return $this->__r($response);
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
        if (!$typeId || !$data) {
            $this->addError('No ID or data informed for the PATCH/PUT request');
            return $this->__r();
        }
        /** @var array $type */
        $type = Zend_Json::decode($data, true);
        $result = $this->model->update($typeId, $type['body']);

        if (!isset($type['body']) || $result['error'] === true) {
            $this->addError(sprintf('An error when we process the PATCH request of ID : %s', $typeId));
            $this->addError($result['message']);
            return $this->__r();
        }

        return $this->__r();
    }

    /**
     * Delete type by identifier
     *
     * @param int $typeId
     * @return array
     */
    public function delete(int $typeId) : array
    {
        if (!$typeId) {
            $this->addError('No type ID');
            return $this->__r();
        }
        /** @var bool $response */
        $response = $this->model->delete($typeId);
        if (!$response) {
            return $this->__r([
                "error" => sprintf("No row for this type ID : %d", $typeId)
            ]);
        }

        return $this->__r();
    }
}