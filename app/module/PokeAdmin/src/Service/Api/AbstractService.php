<?php

/**
 * Class AbstractService
 *
 * @package             PokeAdmin\Service\Api
 * @author              Didier Youn <didier.youn@gmail.com>, Marc Intha-Amnouay <marc.inthaamnouay@gmail.com>, Antoine Renault <antoine.renault.mmi@gmail.com>
 * @copyright           Copyright (c) 2017 Tinwork
 * @license             http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link                https://github.com/Tinwork/ZendPokemon
 */
namespace PokeAdmin\Service\Api;

class AbstractService
{
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
}
