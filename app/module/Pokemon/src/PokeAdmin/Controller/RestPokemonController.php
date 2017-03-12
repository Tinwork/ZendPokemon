<?php

/**
 * Class RestPokemonController
 *
 * @package             Pokemon\PokeAdmin\Controller
 * @author              Didier Youn <didier.youn@gmail.com>, Marc Intha-Amnouay <marc.inthaamnouay@gmail.com>, Antoine Renault <antoine.renault.mmi@gmail.com>
 * @copyright           Copyright (c) 2017 Tinwork
 * @license             http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link                https://github.com/Tinwork/ZendPokemon
 */
namespace Pokemon\PokeAdmin\Controller;

use Pokemon\PokeAdmin\Strategy\PokemonServiceStrategy;
use Pokemon\Common\Controller\AbstractController;
use Zend\View\Model\JsonModel;

class RestPokemonController extends AbstractController
{
    /** @var PokemonServiceStrategy $strategy*/
    protected $strategy;

    /**
     * RestPokemonController constructor.
     *
     * @param PokemonServiceStrategy $strategy
     */
    public function __construct(PokemonServiceStrategy $strategy)
    {
        $this->strategy = $strategy;
    }

    public function showAction()
    {
        var_dump('show'); die;
    }

    public function newAction()
    {
        /** @var string $data */
        $data = $this->request->getContent();

        if (!$this->strategy->save($data)) {
            return false;
        }

        return $this->renderJson([
            "state" => "OK"
        ]);
    }

    public function editAction()
    {
        var_dump('edit'); die;
    }

    public function deleteAction()
    {
        var_dump('delete'); die;
    }
}
