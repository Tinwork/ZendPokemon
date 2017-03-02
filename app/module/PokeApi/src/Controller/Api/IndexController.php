<?php

/**
 * Class IndexController
 *
 * @package             PokeApi\Controller\Api
 * @author              Didier Youn <didier.youn@gmail.com>, Marc Intha-Amnouay <marc.inthaamnouay@gmail.com>, Antoine Renault <antoine.renault.mmi@gmail.com>
 * @copyright           Copyright (c) 2017 Tinwork
 * @license             http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link                https://github.com/Tinwork/ZendPokemon
 */
namespace PokeApi\Controller\Api;

use PokeApi\Controller\AbstractController;
use Zend\View\Model\JsonModel;

class IndexController extends AbstractController
{
    public function indexAction()
    {
        return new JsonModel([
            "test" => "test"
        ]);
    }
}
