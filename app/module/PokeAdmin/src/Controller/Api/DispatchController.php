<?php

/**
 * Class DispatchController
 *
 * @package             PokeAdmin\Controller\Api
 * @author              Didier Youn <didier.youn@gmail.com>, Marc Intha-Amnouay <marc.inthaamnouay@gmail.com>, Antoine Renault <antoine.renault.mmi@gmail.com>
 * @copyright           Copyright (c) 2017 Tinwork
 * @license             http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link                https://github.com/Tinwork/ZendPokemon
 */
namespace PokeAdmin\Controller\Api;

use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\MvcEvent;

use PokeAdmin\Controller\AbstractController;

use TinworkApiConnector\Helper\Dispatcher;

class DispatchController extends AbstractController
{
    /** @var Dispatcher $dispatcher */
    protected $dispatcher = null;
    /** @var array $allowedHttpMethods */
    protected $allowedHttpMethods = [
        "GET",
        "POST",
        "DELETE",
        "PUT",
        "PATCH"
    ];

    /**
     * AbstractController constructor.
     */
    public function __construct()
    {
        $this->dispatcher = new Dispatcher();
    }

    /**
     * Attach event before controller's actions
     *
     * @param EventManagerInterface $events
     * @return $this
     */
    public function setEventManager(EventManagerInterface $events)
    {
        parent::setEventManager($events);
        $events->attach(MvcEvent::EVENT_DISPATCH, [$this, 'preDispatch'], 100);
    }

    /**
     * Pre-dispatch event
     *
     * @param MvcEvent $event
     * @return array|null
     */
    public function preDispatch(MvcEvent $event)
    {
        /** @var \Zend\Http\PhpEnvironment\Request $request */
        $request = $event->getRequest();
        /** @var array $process */
        $process = $this->dispatcher->process($request, $this->allowedHttpMethods, true);
        if (!isset($process["allowed"]) || $process["allowed"] === false) {
            /** @var \Zend\Http\PhpEnvironment\Response $response */
            $response = $event->getResponse();
            $response->setStatusCode($process["code"]);
            /** @var \Zend\View\Model\ViewModel $model */
            $model = $event->getViewModel();
            $model->setTemplate('error/' . $process["code"]);
            $event->stopPropagation(true);
        }
    }
}
