<?php

/**
 * Class PokemonServiceStrategy
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
use Pokemon\Common\Model\Resource\Pokemon;
use Pokemon\Common\Strategy\AbstractRestApiServiceStrategy;

class PokemonServiceStrategy extends AbstractRestApiServiceStrategy
{
    /** @var Pokemon $model */
    protected $model;

    /**
     * PokemonService constructor.
     *
     * @param Pokemon $resource
     */
    public function __construct(Pokemon $resource)
    {
        $this->model = $resource;
    }

    /**
     * Insert pokemon
     *
     * @param string $data
     * @param string $path
     * @return array
     */
    public function save(string $data, string $path = null)
    {
        if (!$data) {
            $this->addError('No data');
            return $this->__r();
        }
        /** @var array $dataToArray */
        $dataToArray = Zend_Json::decode($data, true);
        if (!isset($dataToArray['body']) || !$this->_validFormData($dataToArray['body'], $this->model->getFillables())) {
            $this->addError('Body data parameters are not correct');
            return $this->__r();
        }
        if ($this->verifyUniquesAttributes($this->model->getUniques(), $this->model, $dataToArray['body'])) {
            return $this->__r();
        }
        if (!$this->verifyType($dataToArray['body'])) {
            return $this->__r();
        }
        $dataToArray['body']['type'] = $this->formatArrayString($dataToArray['body']['type']);
        if (isset($dataToArray['body']['evolutions'])) {
            $dataToArray['body']['evolutions'] = $this->prepareEvolutions($dataToArray['body']['evolutions']);
        }
        if (!$this->model->save($dataToArray['body'], $path)) {
            $this->addError('Can\'t save the pokemon in database');
        }

        return $this->__r();
    }

    /**
     * Update pokemon by id
     *
     * @param int $pokemonId
     * @param array $data
     * @return array
     */
    public function update(int $pokemonId, array $data) : array
    {
        if (!$pokemonId || !$data || sizeof($data) < 1) {
            $this->addError('No ID or data informed for the updating request');
            return $this->__r();
        }
        /** @var array $pokemon */;
        $pokemon = Zend_Json::decode($data['data'], true);
        $result = $this->model->update($pokemonId, $pokemon['body']);
        if (!isset($pokemon['body']) || $result['error'] === true) {
            $this->addError(sprintf('An error when we process the update of pokemon ID : %s', $pokemonId));
            $this->addError($result['message']);
            return $this->__r();
        }

        return $this->__r();
    }

    /**
     * Delete pokemon by identifier
     *
     * @param int $pokemonId
     * @return array
     */
    public function delete(int $pokemonId) : array
    {
        if (!$pokemonId) {
            $this->addError('No ID');
            return $this->__r();
        }
        if (!$this->model->delete($pokemonId)) {
            $this->addError(sprintf('Can\'t delete the pokemon from ID : %d', $pokemonId));
            return $this->__r();
        }

        return $this->__r();
    }

    /**
     * Valid form data
     *
     * @param array $form
     * @param array $fillables
     * @return bool
     */
    protected function _validFormData(array $form, array $fillables) : bool
    {
        foreach ($fillables as $fillable) {
            if (!isset($form[$fillable])) {
                return false;
            }
        }
        return true;
    }

    /**
     * Prepare evolutions for database
     *
     * @param array $evolutions
     * @return string
     */
    protected function prepareEvolutions(array $evolutions) : string
    {
        if (!$evolutions) {
            return null;
        }

        return Zend_Json::encode($evolutions, true);
    }

    /**
     * @param array $data
     * @return bool
     */
    protected function verifyType(array $data) : bool
    {
        if (!isset($data['type'])) {
            $this->addError(sprintf('No type ID defined in body data'));
            return false;
        }
        $types = $data['type'];
        if (!is_array($types)) {
            $types = [$types];
        }
        foreach ($types as $type) {
            $typeEntity = $this->model->load($type, 'types');
            if ($typeEntity && is_array($typeEntity) && sizeof($typeEntity) >= 1) {
                continue;
            }
            $this->addError(sprintf('The type id : %s doesnt exist', $type));
            return false;
        }

        return true;
    }
}