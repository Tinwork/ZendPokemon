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
     * @return array
     */
    public function save(string $data)
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
        if ($this->alreadyExist($dataToArray['body'])) {
            $this->addError(sprintf('The pokemon with name : %s already exist', $dataToArray['body']['name']));
            return $this->__r();
        }
        if (isset($dataToArray['body']['evolutions'])) {
            $dataToArray['body']['evolutions'] = $this->prepareEvolutions($dataToArray['body']['evolutions']);
        }
        if (!$this->model->save($dataToArray['body'])) {
            $this->addError('Can\'t save the pokemon in database');
        }

        return $this->__r();
    }

    /**
     * Update pokemon by id
     *
     * @param int $pokemonId
     * @param string $data
     * @return array
     */
    public function update(int $pokemonId, string $data) : array
    {
        if (!$pokemonId || !$data) {
            $this->addError('No ID or data informed for the updating request');
            return $this->__r();
        }
        /** @var array $pokemon */
        $pokemon = Zend_Json::decode($data, true);
        if (!isset($pokemon['body']) || !$this->model->update($pokemonId, $pokemon['body'])) {
            $this->addError(sprintf('An error when we process the update of pokemon ID : %s', $pokemonId));
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
     * Check if Pokemon already exist by name
     *
     * @param array $pokemon
     * @return bool
     */
    protected function alreadyExist(array $pokemon) : bool
    {
        if (!isset($pokemon['name'])) {
            return false;
        }
        /** @var string $pokemonName */
        $pokemonName = $pokemon['name'];
        $target = $this->model->loadByAttribute("name", [
            'name' => $pokemonName
        ]);
        if ($target && sizeof($target) >= 1) {
            return true;
        }

        return false;
    }
}