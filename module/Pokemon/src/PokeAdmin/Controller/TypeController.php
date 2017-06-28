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

use Pokemon\Common\Model\Entity\Type;
use Pokemon\Common\Controller\AbstractController;
use Pokemon\PokeAdmin\Builder\Form\TypeType;
use Pokemon\PokeAdmin\Builder\Validator\TypeFormValidator;
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
     * Create new type
     *
     * @return \Zend\View\Model\JsonModel
     */
    public function create()
    {
        /** @var null $response */
        $response = null;
        /** @var string $data */
        $data = $this->params()->fromPost('data');
        /** @var TypeType $typeFormType */
        $typeFormType = new TypeType();
        $type = new Type();
        $typeFormType->bind($type);
        $typeFormType->setInputFilter(new TypeFormValidator());
        $typeFormType->setData($this->extractData($data));
        if ($typeFormType->isValid()) {
            /** @var array $response */
            $response = $this->typeService->save($data);
        } else {
            $this->typeService->setErrors($this->getFormErrors($typeFormType));
            $response = $this->typeService->__r();
        }

        return $this->renderJson($response);
    }

    /**
     * Update type by id
     *
     * @return \Zend\View\Model\JsonModel
     */
    public function update()
    {
        /** @var int $typeId */
        $typeId = $this->params()->fromRoute('id');
        /** @var array $data */
        $data = $this->processBodyContent($this->getRequest());
        /** @var array $response */
        $response = $this->typeService->update($typeId, $data['data']);

        return $this->renderJson($response);
    }

    /**
     * Destroy type by id
     *
     * @return \Zend\View\Model\JsonModel
     */
    public function destroy()
    {
        /** @var int $typeId */
        $typeId = $this->params()->fromRoute('id');
        /** @var array $response */
        $response = $this->typeService->delete($typeId);

        return $this->renderJson($response);
    }
}