<?php

namespace Pokemon\PokeAdmin\Builder\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class PokemonType extends Form
{
    public function __construct()
    {
        parent::__construct('pokemon_form_add');

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