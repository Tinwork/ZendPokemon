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
use Pokemon\Common\Strategy\UploadServiceStrategy;
use Pokemon\PokeAdmin\Builder\Form\PokemonType;
use Pokemon\PokeAdmin\Builder\Validator\PokemonFormValidator;
use Pokemon\PokeAdmin\Strategy\PokemonServiceStrategy;
use Pokemon\Common\Controller\AbstractController;
use Zend\View\Model\JsonModel;
use Zend\Json\Json as Zend_Json;

class RestPokemonController extends AbstractController
{
    /** @var PokemonServiceStrategy $strategy*/
    protected $strategy;
    /** @var UploadServiceStrategy $upload*/
    protected $upload;

    /**
     * RestPokemonController constructor.
     *
     * @param PokemonServiceStrategy $strategy
     * @param UploadServiceStrategy $upload
     */
    public function __construct(PokemonServiceStrategy $strategy, UploadServiceStrategy $upload)
    {
        $this->strategy = $strategy;
        $this->upload = $upload;
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
        /** @var null $response */
        $response = null;
        /** @var array $data */
        $data = $this->params()->fromPost('data');
        /** @var array $files */
        $files = $this->request->getFiles('file');
        /** @var PokemonType $pokemonFormType */
        $pokemonFormType = new PokemonType();
        $pokemon = new Pokemon();
        $pokemonFormType->bind($pokemon);
        $pokemonFormType->setInputFilter(new PokemonFormValidator());
        $pokemonFormType->setData($this->extractData($data));
        if ($pokemonFormType->isValid()) {
            $path = $this->upload->upload($files);
            $response = $this->strategy->save($data, $path);
        } else {
            $this->strategy->setErrors($this->getFormErrors($pokemonFormType));
            $response = $this->strategy->__r();
        }

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
        /** @var array $data */
        $data = $this->processBodyContent($this->getRequest(), self::EXTRACT_JSON);
        $base64 = $this->processBodyContent($this->getRequest(), self::EXTRACT_BASE64);
        /** @var array $response */
        $response = $this->strategy->update($pokemonId, $data);
        $responseFilePatch = [];
        if (isset($response['code']) && $response['code'] === 200) {
            $data = $this->extractData($data['data']);
            if ($this->upload->validPatchUploadFile($base64, $data)) {
                $patch = [
                    'data' => Zend_Json::encode(['body' => [
                        'thumbnail' => $this->upload->convert($base64, $data)
                    ]
                    ])
                ];
                $responseFilePatch = $this->strategy->update($pokemonId, $patch);
            }
        }

        return $this->renderJson(array_merge($response, $responseFilePatch));
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
