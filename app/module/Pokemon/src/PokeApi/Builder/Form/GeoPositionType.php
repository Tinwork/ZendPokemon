<?php

/**
 * Class GeoPositionType
 *
 * @package             Pokemon\PokeApi\Builder\Form
 * @author              Didier Youn <didier.youn@gmail.com>, Marc Intha-Amnouay <marc.inthaamnouay@gmail.com>, Antoine Renault <antoine.renault.mmi@gmail.com>
 * @copyright           Copyright (c) 2017 Tinwork
 * @license             http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link                https://github.com/Tinwork/ZendPokemon
 */
namespace Pokemon\PokeApi\Builder\Form;

use Pokemon\Common\Model\Hydrator\GeoPositionHydrator;
use Zend\Form\Form;
use Zend\Form\Element;

class GeoPositionType extends Form
{
    public function __construct()
    {
        parent::__construct('position_form_add');

        $this->setHydrator(new GeoPositionHydrator());

        $longitude = new Element\Text('longitude');
        $latitude = new Element\Text('latitude');
        $submit = new Element\Submit('submit');

        $this->add($longitude);
        $this->add($latitude);
        $this->add($submit);
    }
}