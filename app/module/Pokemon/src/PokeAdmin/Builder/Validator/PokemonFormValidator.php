<?php
/**
 * Created by IntelliJ IDEA.
 * User: Didier
 * Date: 14/04/2017
 * Time: 09:22
 */
namespace Pokemon\PokeAdmin\Builder\Validator;

use Zend\Filter\FilterChain;
use Zend\Filter\StringTrim;
use Zend\Form\Element;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputProviderInterface;
use Zend\Validator\Regex as RegexValidator;
use Zend\Validator\StringLength;
use Zend\Validator\ValidatorChain;
use Zend\Validator\ValidatorInterface;

class PokemonFormValidator extends InputFilter
{
    public function __construct()
    {
        $title = new Input('name');
        $title->setRequired(true);
        $title->setFilterChain($this->getStringTrimFilterChain());
        $title->setValidatorChain($this->getTitleValidatorChain());
    }

    protected function getTitleValidatorChain()
    {
        $stringLength = new StringLength();
        $stringLength->setMin(5);
        $stringLength->setMax(50);

        return $stringLength;
    }

    protected function getStringTrimFilterChain()
    {
        $filterChain = new FilterChain();
        $filterChain->attach(new StringTrim());
        return $filterChain;
    }
}