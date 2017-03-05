<?php

/**
 * Class OAuthService
 *
 * @package             PokeAdmin\Service\Api
 * @author              Didier Youn <didier.youn@gmail.com>, Marc Intha-Amnouay <marc.inthaamnouay@gmail.com>, Antoine Renault <antoine.renault.mmi@gmail.com>
 * @copyright           Copyright (c) 2017 Tinwork
 * @license             http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link                https://github.com/Tinwork/ZendPokemon
 */
namespace PokeAdmin\Service\Api;

use PokeAdmin\Model\Resource\Pokemon;
use Zend\Json\Json as Zend_Json;

class PokemonService extends AbstractService
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
     * @return bool
     */
    public function save(string $data) : bool
    {
        if (!isset($data)) {
            return false;
        }
        /** @var array $dataToArray */
        $dataToArray = Zend_Json::decode($data, true);
        if (!$this->_validFormData($dataToArray['body'], $this->model->getFillables())) {
            die('Unvalid form data');
        }
        if (!$this->model->save($dataToArray['body'])) {
            die('Can not save form data');
        }

        return true;
    }
}
