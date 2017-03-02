<?php

/**
 * Class IndexController
 *
 * @package             PokeAdmin\Controller\Adminhtml
 * @author              Didier Youn <didier.youn@gmail.com>, Marc Intha-Amnouay <marc.inthaamnouay@gmail.com>, Antoine Renault <antoine.renault.mmi@gmail.com>
 * @copyright           Copyright (c) 2017 Tinwork
 * @license             http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link                https://github.com/Tinwork/ZendPokemon
 */
namespace PokeAdmin\Controller\Adminhtml;

use PokeAdmin\Controller\AbstractController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractController
{
    public function indexAction()
    {
        return new ViewModel();
    }
}
