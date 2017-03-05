<?php

/**
 * Class OAuthController
 *
 * @package             PokeAdmin\Controller
 * @author              Didier Youn <didier.youn@gmail.com>, Marc Intha-Amnouay <marc.inthaamnouay@gmail.com>, Antoine Renault <antoine.renault.mmi@gmail.com>
 * @copyright           Copyright (c) 2017 Tinwork
 * @license             http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link                https://github.com/Tinwork/ZendPokemon
 */
namespace PokeAdmin\Controller;

use Zend\View\Model\JsonModel;
use PokeAdmin\Service\OAuthService;

class OAuthController extends AbstractController
{
    /** @var OAuthService $service */
    protected $service = null;

    /**
     * AuthController constructor.
     *
     * @param $service
     */
    public function __construct($service)
    {
        $this->service = $service;
    }

    /**
     * Authenticate user
     *
     * @return \Zend\Stdlib\ResponseInterface|JsonModel
     */
    public function authAction()
    {
        if (!$this->request->isPost()) {
            $response = $this->getResponse();
            $response->setStatusCode(403);

            return $response;
        }
        /** @var string $username */
        $username = $this->request->getPost('username');
        /** @var string $password */
        $password = $this->request->getPost('password');
        /** @var bool|string $token */
        $token = $this->service->forward($username, $password);
        if (!$token) {
            $response = $this->getResponse();
            $response->setStatusCode(401);
            return $response;
        }

        return new JsonModel([
            "token" => $token
        ]);
    }

    public function newAction()
    {
        if (!$this->request->isPost()) {
            $response = $this->getResponse();
            $response->setStatusCode(403);

            return $response;
        }
        /** @var string $username */
        $token = $this->request->getPost('token');
        $this->service->validateToken($token);
    }
}
