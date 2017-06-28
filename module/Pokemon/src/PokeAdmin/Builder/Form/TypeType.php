<?php

/**
 * Class TypeType
 *
 * @package             Pokemon\PokeAdmin\Builder\Form
 * @author              Didier Youn <didier.youn@gmail.com>, Marc Intha-Amnouay <marc.inthaamnouay@gmail.com>, Antoine Renault <antoine.renault.mmi@gmail.com>
 * @copyright           Copyright (c) 2017 Tinwork
 * @license             http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link                https://github.com/Tinwork/ZendPokemon
 */
namespace Pokemon\PokeAdmin\Builder\Form;

use Pokemon\Common\Model\Hydrator\TypeHydrator;
use Zend\Form\Form;
use Zend\Form\Element;

class TypeType extends Form
{
    public function __construct()
    {
        parent::__construct('type_form_add');

        $this->setHydrator(new TypeHydrator());

        $label = new Element\Text('label');
        $color = new Element\Text('color');
        $badge = new Element\Text('badge');
        $submit = new Element\Submit('submit');

        $this->add($label);
        $this->add($color);
        $this->add($badge);
        $this->add($submit);
    }
}