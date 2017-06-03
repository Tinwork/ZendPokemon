<?php

/**
 * Class OAuthServiceStrategy
 *
 * @package             Pokemon\PokeAdmin\Strategy
 * @author              Didier Youn <didier.youn@gmail.com>, Marc Intha-Amnouay <marc.inthaamnouay@gmail.com>, Antoine Renault <antoine.renault.mmi@gmail.com>
 * @copyright           Copyright (c) 2017 Tinwork
 * @license             http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link                https://github.com/Tinwork/ZendPokemon
 */
namespace Pokemon\PokeAdmin\Strategy;

use Firebase\JWT\JWT;

use Pokemon\Common\Model\Resource\User;
use Pokemon\Common\Strategy\AbstractRestApiServiceStrategy;

class OAuthServiceStrategy extends AbstractRestApiServiceStrategy
{
    /** @var User $model */
    protected $model;
    /** @var array $config */
    protected $config;

    /**
     * OAuth constructor.
     *
     * @param User $userService
     * @param array $config
     */
    public function __construct(User $userService, array $config)
    {
        $this->model = $userService;
        $this->config = $config;
    }

    /**
     *
     * @param string $username
     * @param string $password
     * @return array
     */
    public function forward(string $username, string $password) : array
    {
        $user = $this->authenticate($username, $password);
        if (!$user) {
            $this->addError(sprintf('The user as : %s doesn\'t exist', $username));
            return $this->__r();
        }
        $token = $this->getToken($user);
        if (!$token) {
            $this->addError(sprintf('The token for the user : %s has expired or is not validate', $username));
            return $this->__r();
        }

        return $this->__r([
           'token' => $token
        ]);
    }

    /**
     * Check if user exist in database
     *
     * @param string $username
     * @param string $password
     * @return bool|User
     */
    public function authenticate(string $username, string $password)
    {
        if (!isset($username) || !isset($password)) {
            return false;
        }
        /** @var array $hash */
        $hash = $this->model->loadByAttribute("hash", [
            'username' => $username
        ]);
        $hash = $hash[0]["password"];
        if (!password_verify($password, $hash)) {
            return false;
        }
        return true;
    }

    /**
     * @param User $user
     * @return string
     */
    protected function getToken($user)
    {
        /** @var array $jwtConfig */
        $jwtConfig = $this->getJWTConfiguration();
        $issuedAt   = time();
        $notBefore  = $issuedAt + 10;
        $expire     = $notBefore + $jwtConfig['TOKEN_EXPIRED_AT'];

        $data = [
            'iat'  => $issuedAt,
            'jti'  => base64_encode(mcrypt_create_iv(32)),
            'iss'  => $jwtConfig['SECRET_APPLICATION_HOST'],
            'nbf'  => $notBefore,
            'exp'  => $expire,
            'data' => [
                'userId'   => $user['id'],
                'userName' => $user['username'],
            ]
        ];
        header('Content-type: application/json');

        return JWT::encode(
            $data,
            base64_decode($jwtConfig['SECRET_APPLICATION_ID']),
            $jwtConfig['JWT_ALGORITHM']
        );
    }

    /**
     * Try to decode JWT
     *
     * @param string $token
     * @return bool
     */
    public function validateToken(string $token) : bool
    {
        /** @var array $jwtConfig */
        $jwtConfig = $this->getJWTConfiguration();
        /** @var string $secretKey */
        $secretKey = base64_decode($jwtConfig['SECRET_APPLICATION_ID']);
        try {
            /** @var array $decodeToken */
            $decodeToken = JWT::decode($token, $secretKey, [$jwtConfig['JWT_ALGORITHM']]);
            if ($decodeToken) {
                return true;
            }
        } catch (\Exception $e) {
            return false;
        }
        return false;
    }

    /**
     * Get JWT Configuration
     *
     * @return array
     */
    private function getJWTConfiguration() : array
    {
        return $this->config['api'];
    }
}
