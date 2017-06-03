<?php

/**
 * Class UserType
 *
 * @package             Pokemon\PokeAdmin\Builder\Form
 * @author              Didier Youn <didier.youn@gmail.com>, Marc Intha-Amnouay <marc.inthaamnouay@gmail.com>, Antoine Renault <antoine.renault.mmi@gmail.com>
 * @copyright           Copyright (c) 2017 Tinwork
 * @license             http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link                https://github.com/Tinwork/ZendPokemon
 */
namespace Pokemon\PokeAdmin\Builder\Form;

use Pokemon\Common\Model\Hydrator\UserHydrator;
use Zend\Form\Form;
use Zend\Form\Element;

class UserType extends Form
{
    public function __construct()
    {
        parent::__construct('admin_form_add');

        $this->setHydrator(new UserHydrator());

        $username = new Element\Text('username');
        $password = new Element\Text('password');
        $submit = new Element\Submit('submit');

        $this->add($username);
        $this->add($password);
        $this->add($submit);
    }
}