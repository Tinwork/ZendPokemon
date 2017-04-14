<?php

/**
 * Class TypeController
 *
 * @package             Pokemon\PokeAdmin\Controller
 * @author              Didier Youn <didier.youn@gmail.com>, Marc Intha-Amnouay <marc.inthaamnouay@gmail.com>, Antoine Renault <antoine.renault.mmi@gmail.com>
 * @copyright           Copyright (c) 2017 Tinwork
 * @license             http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link                https://github.com/Tinwork/ZendPokemon
 */
namespace Pokemon\PokeAdmin\Controller;

use Pokemon\Common\Controller\AbstractController;
use Pokemon\PokeAdmin\Strategy\TypeServiceStrategy;

class TypeController extends AbstractController
{
    /** @var TypeServiceStrategy $typeService */
    protected $typeService;

    /**
     * TypeController constructor.
     * @param TypeServiceStrategy $service
     */
    public function __construct(TypeServiceStrategy $service)
    {
        $this->typeService = $service;
    }

    /**
     * Render all types
     *
     * @return \Zend\View\Model\JsonModel
     */
    public function show()
    {
        die('show');
    }

    /**
     * Render type by id
     *
     * @return \Zend\View\Model\JsonModel
     */
    public function view()
    {
        die('view');
    }

    /**
     * Create new type
     *
     * @return \Zend\View\Model\JsonModel
     */
    public function create()
    {
        /** @var string $data */
        $data = $this->request->getContent();
        /** @var array $response */
        $response = $this->typeService->save($data);

        return $this->renderJson($response);
    }

    /**
     * Update type by id
     *
     * @return \Zend\View\Model\JsonModel
     */
    public function update()
    {
        die('update');
    }

    /**
     * Destroy type by id
     *
     * @return \Zend\View\Model\JsonModel
     */
    public function destroy()
    {
        die('destroy');
    }
}