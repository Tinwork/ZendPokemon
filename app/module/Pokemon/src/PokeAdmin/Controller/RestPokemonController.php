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

use Pokemon\Common\Model\Entity\Pokemon;
use Pokemon\PokeAdmin\Builder\Form\PokemonType;
use Pokemon\PokeAdmin\Builder\Validator\PokemonFormValidator;
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

    /**
     * Get pokemon details
     *
     * @return JsonModel
     */
    public function view()
    {
        var_dump('show'); die;
    }

    /**
     * Create pokemon
     *
     * @return JsonModel
     */
    public function create()
    {
        /** @var string $data */
        $data = $this->request->getContent();
        /** @var PokemonType $pokemonFormType */
        $pokemonFormType = new PokemonType();
        $pokemonFormType->setInputFilter(new PokemonFormValidator());

        $pokemonFormType->setData([
            "name" => null,
            "type_id" => 1,
            "rank" => 34,
            "evolutions" => "lol"
        ]);

        if ($pokemonFormType->isValid()) {
            var_dump("test");
        } else {
            var_dump("yo");
        }
        die;

        $response = $this->strategy->save($data);

        return $this->renderJson($response);
    }

    /**
     * Update pokemon
     *
     * @return JsonModel
     */
    public function update()
    {
        /** @var int $pokemonId */
        $pokemonId = $this->params()->fromRoute('id');
        /** @var string $pokemonData */
        $pokemonData = $this->request->getContent();
        /** @var array $response */
        $response = $this->strategy->update($pokemonId, $pokemonData);

        return $this->renderJson($response);
    }

    /**
     * Delete pokemon
     *
     * @return JsonModel
     */
    public function destroy()
    {
        /** @var int $pokemonId */
        $pokemonId = $this->params()->fromRoute('id');
        /** @var array $response */
        $response = $this->strategy->delete($pokemonId);

        return $this->renderJson($response);
    }
}
