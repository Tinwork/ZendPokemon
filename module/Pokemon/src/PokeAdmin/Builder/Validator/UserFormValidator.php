<?php

/**
 * Class UserFormValidator
 *
 * @package             Pokemon\PokeAdmin\Builder\Validator
 * @author              Didier Youn <didier.youn@gmail.com>, Marc Intha-Amnouay <marc.inthaamnouay@gmail.com>, Antoine Renault <antoine.renault.mmi@gmail.com>
 * @copyright           Copyright (c) 2017 Tinwork
 * @license             http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link                https://github.com/Tinwork/ZendPokemon
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

class UserFormValidator extends InputFilter
{
    public function __construct()
    {
        $username = new Input('username');
        $username->setRequired(true);
        $username->setFilterChain($this->getStringTrimFilterChain());

        $password = new Input('password');
        $password->setRequired(true);
        $password->setFilterChain($this->getStringTrimFilterChain());

        $this->add($username);
        $this->add($password);
    }

    protected function getStringTrimFilterChain()
    {
        $filterChain = new FilterChain();
        $filterChain->attach(new StringTrim());

        return $filterChain;
    }
}