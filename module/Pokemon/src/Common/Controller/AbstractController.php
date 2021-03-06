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

use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\Json\Json as Zend_Json;

class AbstractController extends AbstractActionController
{
    /** @var string BODY_KEY */
    const BODY_KEY = "body";
    /** @var string PATTERN_JSON_EXTRACT */
    const PATTERN_JSON_EXTRACT = '/\{(?:[^{}]|(?R))*\}/i';
    /** @var string PATTERN_BASE64_EXTRACT */
    const PATTERN_BASE64_EXTRACT = '/(?P<base64>data.*base64.*[?=|-])/i';
    /** @var string EXTRACT_JSON */
    const EXTRACT_JSON = "JSON";
    /** @var string EXTRACT_BASE64 */
    const EXTRACT_BASE64 = "BASE64";

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

    /**
     * Extract data
     *
     * @param string $data
     * @return array
     */
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

    /**
     * Get form errors in case when hydrate entity
     *
     * @param $form
     * @return array
     */
    public function getFormErrors($form)
    {
        $errors = [];
        $messages = $form->getMessages();
        foreach ($messages as $message) {
            $errors[] = reset($message);
        }

        return $errors;
    }

    /**
     * Process body content and extract form data
     *
     * @param Request $request
     * @param string $type
     * @return array
     */
    public function processBodyContent(Request $request, string $type = self::PATTERN_JSON_EXTRACT) : array
    {
        try {
            /** @var string|null $content */
            $content = $request->getContent();
            if (!$content) {
                return [];
            }
            switch ($type) {
                case self::EXTRACT_BASE64 :
                    $pattern = self::PATTERN_BASE64_EXTRACT;
                    break;
                default:
                    $pattern = self::PATTERN_JSON_EXTRACT;
                    break;
            }
            preg_match($pattern, $content, $matches);
            if (!$matches || !isset($matches[0])) {
                return [];
            }
            if ($type == self::EXTRACT_BASE64) {
                return [ 'data' => (string)$matches[0] ];
            }
            if (!$this->isJson($matches[0])) {
                return [];
            }
            return [ 'data' => (string)$matches[0] ];
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * @param $string
     * @return bool
     */
    private function isJson($string) {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
}