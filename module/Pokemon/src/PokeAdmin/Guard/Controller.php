<?php

/**
 * Class Controller
 *
 * @package             Pokemon\PokeAdmin\Guard
 * @author              Didier Youn <didier.youn@gmail.com>, Marc Intha-Amnouay <marc.inthaamnouay@gmail.com>, Antoine Renault <antoine.renault.mmi@gmail.com>
 * @copyright           Copyright (c) 2017 Tinwork
 * @license             http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link                https://github.com/Tinwork/ZendPokemon
 */
namespace Pokemon\PokeAdmin\Guard;

use Zend\Mvc\MvcEvent;
use Zend\ServiceManager\ServiceLocatorInterface;

use Pokemon\PokeAdmin\Exception\UnAuthorizedException;

class Controller extends AbstractGuard
{
    /** @var ServiceLocatorInterface $serviceLocator */
    protected $serviceLocator;
    /**
     * Marker for invalid controllers errors
     */
    const ERROR = 'error-unauthorized-controller';

    /**
     * Route constructor.
     *
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function __construct(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * @param MvcEvent $event
     */
    public function onDispatch(MvcEvent $event)
    {

    }
}