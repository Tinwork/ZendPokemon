<?php

/**
 * Class TypeController
 *
 * @package             Pokemon\PokeApi\Controller
 * @author              Didier Youn <didier.youn@gmail.com>, Marc Intha-Amnouay <marc.inthaamnouay@gmail.com>, Antoine Renault <antoine.renault.mmi@gmail.com>
 * @copyright           Copyright (c) 2017 Tinwork
 * @license             http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link                https://github.com/Tinwork/ZendPokemon
 */
namespace Pokemon\PokeApi\Controller;

use Pokemon\Common\Controller\AbstractController;
use Pokemon\PokeApi\Strategy\TypeServiceStrategy;

class TypeController extends AbstractController
{
    /** @var TypeServiceStrategy*/
    protected $strategy;

    /**
     * TypeController constructor.
     *
     * @param TypeServiceStrategy $strategy
     */
    public function __construct(TypeServiceStrategy $strategy)
    {
        $this->strategy = $strategy;
    }

    /**
     * @return \Zend\View\Model\JsonModel
     */
    public function showAction()
    {
        $typeId = $this->params()->fromRoute('id');
        $collection = $this->strategy->fetch($typeId);

        return $this->renderJson([
            'collection' => $collection
        ]);
    }

    /**
     * Get all badges from server
     */
    public function badgeAction()
    {
        $queryParams = $this->getRequest()->getQuery('q');
        $queryParams = explode(',', $queryParams);

        $collection = $this->strategy->fetchBadgesType($queryParams);

        return $this->renderJson([
            'collection' => $collection
        ]);
    }

    /**
     * @return \Zend\View\Model\JsonModel
     */
    public function getPokemonAction()
    {
        $queryParams = $this->getRequest()->getQuery('query');
        $queryParams = explode(',', $queryParams);
        $typeId = $this->params()->fromRoute('id');

        $collection = $this->strategy->fetchPokemonsByType($typeId, $queryParams);

        return $this->renderJson([
            'collection' => $collection
        ]);
    }

}