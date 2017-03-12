<?php

/**
 * Class OAuthController
 *
 * @package             Pokemon\PokeAdmin\Controller
 * @author              Didier Youn <didier.youn@gmail.com>, Marc Intha-Amnouay <marc.inthaamnouay@gmail.com>, Antoine Renault <antoine.renault.mmi@gmail.com>
 * @copyright           Copyright (c) 2017 Tinwork
 * @license             http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link                https://github.com/Tinwork/ZendPokemon
 */
namespace Pokemon\PokeAdmin\Controller;

use Pokemon\PokeAdmin\Strategy\OAuthServiceStrategy;
use Pokemon\Common\Controller\AbstractController;

class OAuthController extends AbstractController
{
    /** @var OAuthServiceStrategy */
    protected $oauthService;

    /**
     * OAuthController constructor.
     *
     * @param OAuthServiceStrategy $service
     */
    public function __construct(OAuthServiceStrategy $service)
    {
        $this->oauthService = $service;
    }

    /**
     * Authenticate user
     *
     * @return \Zend\Stdlib\ResponseInterface|\Zend\View\Model\JsonModel
     */
    public function authAction()
    {
        /** @var string $username */
        $username = $this->request->getPost('username');
        /** @var string $password */
        $password = $this->request->getPost('password');
        /** @var bool|string $token */
        $token = $this->oauthService->forward($username, $password);
        if (!$token) {
            $response = $this->getResponse();
            $response->setStatusCode(401);
            return $response;
        }

        return $this->renderJson([
            "token" => $token
        ]);
    }
}
