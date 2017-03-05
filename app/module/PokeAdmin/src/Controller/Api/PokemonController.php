<?php

/**
 * Class PokemonController
 *
 * @package             PokeAdmin\Controller\Api
 * @author              Didier Youn <didier.youn@gmail.com>, Marc Intha-Amnouay <marc.inthaamnouay@gmail.com>, Antoine Renault <antoine.renault.mmi@gmail.com>
 * @copyright           Copyright (c) 2017 Tinwork
 * @license             http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link                https://github.com/Tinwork/ZendPokemon
 */
namespace PokeAdmin\Controller\Api;

use PokeAdmin\Controller\AbstractController;
use PokeAdmin\Service\Api\PokemonService;
use Zend\View\Model\JsonModel;

class PokemonController extends AbstractController
{
    /** @var PokemonService $service */
    protected $service;

    /**
     * PokemonController constructor.
     *
     * @param PokemonService $service
     */
    public function __construct(PokemonService $service)
    {
        $this->service = $service;
    }

    public function newAction()
    {
        /** @var string $data */
        $data = $this->request->getContent();

        if (!$this->service->save($data)) {
            return false;
        }

        return new JsonModel([
            "state" => "OK"
        ]);
    }
}
