<?php

/**
 * Class TypeServiceStrategy
 *
 * @package             Pokemon\PokeAdmin\Strategy
 * @author              Didier Youn <didier.youn@gmail.com>, Marc Intha-Amnouay <marc.inthaamnouay@gmail.com>, Antoine Renault <antoine.renault.mmi@gmail.com>
 * @copyright           Copyright (c) 2017 Tinwork
 * @license             http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link                https://github.com/Tinwork/ZendPokemon
 */
namespace Pokemon\PokeAdmin\Strategy;

use Zend\Db\Exception\ErrorException;
use Zend\Json\Json as Zend_Json;

use Pokemon\Common\Model\Resource\Type;
use Pokemon\Common\Strategy\AbstractRestApiServiceStrategy;

class TypeServiceStrategy extends AbstractRestApiServiceStrategy
{
    /** @var Type $model */
    protected $model;

    /**
     * TypeServiceStrategy constructor.
     *
     * @param Type $resource
     */
    public function __construct(Type $resource)
    {
        $this->model = $resource;
    }
}