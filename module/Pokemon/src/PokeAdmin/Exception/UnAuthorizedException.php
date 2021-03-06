<?php

/**
 * Class UnAuthorizedException
 *
 * @package             Pokemon\PokeAdmin\Exception
 * @author              Didier Youn <didier.youn@gmail.com>, Marc Intha-Amnouay <marc.inthaamnouay@gmail.com>, Antoine Renault <antoine.renault.mmi@gmail.com>
 * @copyright           Copyright (c) 2017 Tinwork
 * @license             http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link                https://github.com/Tinwork/ZendPokemon
 */
namespace Pokemon\PokeAdmin\Exception;

use Zend\Json\Exception\BadMethodCallException;

class UnAuthorizedException extends BadMethodCallException
{
    private $content = null;

    public function getError()
    {
        return $this->content;
    }
}