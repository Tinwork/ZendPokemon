<?php

/**
 * Class PokemonType
 *
 * @package             Pokemon\PokeAdmin\Builder\Form
 * @author              Didier Youn <didier.youn@gmail.com>, Marc Intha-Amnouay <marc.inthaamnouay@gmail.com>, Antoine Renault <antoine.renault.mmi@gmail.com>
 * @copyright           Copyright (c) 2017 Tinwork
 * @license             http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link                https://github.com/Tinwork/ZendPokemon
 */
namespace Pokemon\PokeAdmin\Builder\Form;

use Pokemon\Common\Model\Hydrator\PokemonHydrator;
use Zend\Form\Form;
use Zend\Form\Element;

class PokemonType extends Form
{
    public function __construct()
    {
        parent::__construct('pokemon_form_add');

        $this->setHydrator(new PokemonHydrator());

        $name = new Element\Text('name');
        $type = new Element\Text('type_id');
        $rank = new Element\Text('rank');
        $evolutions = new Element\Textarea('evolutions');
        $submit = new Element\Submit('submit');

        $this->add($name);
        $this->add($type);
        $this->add($rank);
        $this->add($evolutions);
        $this->add($submit);
    }
}