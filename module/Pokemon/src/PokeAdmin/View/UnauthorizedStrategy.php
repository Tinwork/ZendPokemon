<?php

/**
 * Class UnauthorizedStrategy
 *
 * @package             Pokemon\PokeAdmin\View
 * @author              Didier Youn <didier.youn@gmail.com>, Marc Intha-Amnouay <marc.inthaamnouay@gmail.com>, Antoine Renault <antoine.renault.mmi@gmail.com>
 * @copyright           Copyright (c) 2017 Tinwork
 * @license             http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link                https://github.com/Tinwork/ZendPokemon
 */
namespace Pokemon\PokeAdmin\View;

use Pokemon\PokeAdmin\Exception\UnAuthorizedException;
use Pokemon\PokeAdmin\Guard\Route;

use Zend\Http\Response as HttpResponse;
use Zend\Mvc\Application;
use Zend\Mvc\MvcEvent;
use Zend\Stdlib\ResponseInterface as Response;
use Zend\View\Model\ViewModel;

class UnauthorizedStrategy
{
    /**
     * @var string
     */
    protected $template;
    /**
     * @var \Zend\Stdlib\CallbackHandler[]
     */
    protected $listeners = array();
    /**
     * @param string $template name of the template to use on unauthorized requests
     */
    public function __construct($template)
    {
        $this->template = (string) $template;
    }

    /**
     * @param string $template
     */
    public function setTemplate($template)
    {
        $this->template = (string) $template;
    }
    /**
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }
    /**
     * Callback used when a dispatch error occurs. Modifies the
     * response object with an according error if the application
     * event contains an exception related with authorization.
     *
     * @param MvcEvent $event
     *
     * @return void
     */
    public function onDispatchError(MvcEvent $event)
    {
        // Do nothing if the result is a response object
        $result   = $event->getResult();
        $response = $event->getResponse();
        if ($result instanceof Response || ($response && ! $response instanceof HttpResponse)) {
            return;
        }
        // Common view variables
        $viewVariables = array(
            'error'      => $event->getParam('error'),
            'identity'   => $event->getParam('identity'),
        );
        switch ($event->getError()) {
            case Route::ERROR:
                $viewVariables['route'] = $event->getParam('route');
                $viewVariables['reason'] = $event->getParam('exception')->getMessage();
                break;
            case Application::ERROR_EXCEPTION:
                if (!($event->getParam('exception') instanceof UnAuthorizedException)) {
                    return;
                }
                $viewVariables['reason'] = $event->getParam('exception')->getMessage();
                $viewVariables['error']  = 'error-unauthorized';
                break;
            default:
                /*
                 * do nothing if there is no error in the event or the error
                 * does not match one of our predefined errors (we don't want
                 * our 403 template to handle other types of errors)
                 */
                return;
        }
        $model = new ViewModel($viewVariables);
        $response = $response ?: new HttpResponse();
        $model->setTemplate($this->getTemplate());
        $event->getViewModel()->addChild($model);
        $response->setStatusCode(403);
        $event->setResponse($response);
    }
}