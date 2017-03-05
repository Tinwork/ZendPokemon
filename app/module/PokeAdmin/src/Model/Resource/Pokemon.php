<?php

/**
 * Class Pokemon
 *
 * @package             PokeAdmin\Model\Resource
 * @author              Didier Youn <didier.youn@gmail.com>, Marc Intha-Amnouay <marc.inthaamnouay@gmail.com>, Antoine Renault <antoine.renault.mmi@gmail.com>
 * @copyright           Copyright (c) 2017 Tinwork
 * @license             http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link                https://github.com/Tinwork/ZendPokemon
 */
namespace PokeAdmin\Model\Resource;

use PokeAdmin\Model\Resource\Facade\PokemonInterface;
use Zend\Db\Adapter\AdapterAwareTrait;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Where;

class Pokemon implements PokemonInterface
{
    use AdapterAwareTrait;
    /** @var string $table */
    protected $table = "pokemons";
    /** @var array $fillables */
    protected $fillables = ["name", "rank"];

    /**
     * @inheritdoc
     */
    public function save(array $data) : bool
    {
        $sql = new Sql($this->adapter);
        $insert = $sql->insert($this->table)
            ->values([
                'name'  => $data['name'],
                'rank'  => $data['rank']
            ]);

        $statement = $sql->prepareStatementForSqlObject($insert);
        $result = $statement->execute();

        var_dump($result);
        // Todo finir là
    }

    /**
     * @return array
     */
    public function getFillables() : array
    {
        return $this->fillables;
    }
}
