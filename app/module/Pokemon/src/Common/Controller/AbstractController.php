<?php

/**
 * Class AbstractController
 *
 * @package             Pokemon\Common\Controller
 * @author              Didier Youn <didier.youn@gmail.com>, Marc Intha-Amnouay <marc.inthaamnouay@gmail.com>, Antoine Renault <antoine.renault.mmi@gmail.com>
 * @copyright           Copyright (c) 2017 Tinwork
 * @license             http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link                https://github.com/Tinwork/ZendPokemon
 */
namespace Pokemon\Common\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\Json\Json as Zend_Json;

class AbstractController extends AbstractActionController
{
    /** @var string BODY_KEY */
    const BODY_KEY = "body";

    /**
     * Pre-dispatch to good actions for REST routes
     */
    public function preDispatchAction()
    {
        $event = $this->getEvent();
        $app = $event->getApplication();
        $sm = $app->getServiceManager();

        $dispatcher = $sm->get('PokeAdmin\Dispatcher');

        $restAction = $dispatcher->dispatchRoute($event);
        if (!method_exists($this, $restAction)) {
            return $dispatcher->triggerDispatchError($event);
        }

        return $this->$restAction();
    }

    /**
     * Return JSON
     *
     * @param array $params
     * @return JsonModel
     */
    protected function renderJson(array $params)
    {
        return new JsonModel($params);
    }

    protected function extractData(string $data)
    {
        try {
            if (Zend_Json::decode($data, 'json')) {
                $data = Zend_Json::decode($data, 'json');
                if (!isset($data[self::BODY_KEY])) {
                    return [];
                }
            }
        } catch (\Exception $e) {
            return [];
        }

        return $data[self::BODY_KEY];
    }
}