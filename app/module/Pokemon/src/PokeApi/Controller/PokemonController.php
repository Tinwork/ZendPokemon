<?php

/**
 * Class PokemonController
 *
 * @package             Pokemon\PokeApi\Controller
 * @author              Didier Youn <didier.youn@gmail.com>, Marc Intha-Amnouay <marc.inthaamnouay@gmail.com>, Antoine Renault <antoine.renault.mmi@gmail.com>
 * @copyright           Copyright (c) 2017 Tinwork
 * @license             http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link                https://github.com/Tinwork/ZendPokemon
 */
namespace Pokemon\PokeApi\Controller;

use Zend\View\Model\JsonModel;
use Pokemon\Common\Controller\RenderController;

class PokemonController extends RenderController
{
    public function showAction()
    {
        return $this->renderJson([
            'test' => 'test'
        ]);
    }
}