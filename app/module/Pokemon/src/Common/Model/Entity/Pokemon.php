<?php

/**
 * Class Pokemon
 *
 * @package             Pokemon\Common\Model\Entity
 * @author              Didier Youn <didier.youn@gmail.com>, Marc Intha-Amnouay <marc.inthaamnouay@gmail.com>, Antoine Renault <antoine.renault.mmi@gmail.com>
 * @copyright           Copyright (c) 2017 Tinwork
 * @license             http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link                https://github.com/Tinwork/ZendPokemon
 */
namespace Pokemon\Common\Model\Entity;

class Pokemon
{
    /** @var int $id */
    protected $id;
    /** @var string $name */
    protected $name;
    /** @var string $rank */
    protected $rank;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getRank(): string
    {
        return $this->rank;
    }

    /**
     * @param string $rank
     */
    public function setRank(string $rank)
    {
        $this->rank = $rank;
    }
}
