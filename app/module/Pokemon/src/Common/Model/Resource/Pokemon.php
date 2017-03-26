<?php

/**
 * Class Pokemon
 *
 * @package             Pokemon\Common\Model\Resource
 * @author              Didier Youn <didier.youn@gmail.com>, Marc Intha-Amnouay <marc.inthaamnouay@gmail.com>, Antoine Renault <antoine.renault.mmi@gmail.com>
 * @copyright           Copyright (c) 2017 Tinwork
 * @license             http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link                https://github.com/Tinwork/ZendPokemon
 */
namespace Pokemon\Common\Model\Resource;

use Pokemon\Common\Model\Facade\PokemonFacade;
use Zend\Db\Adapter\AdapterAwareTrait;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Where;

class Pokemon implements PokemonFacade
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

        // TODO : retourner l'id
        return true;
    }

    /**
     * @inheritdoc
     */
    public function delete(int $pokemonId) : bool
    {
        $where = new Where();
        $where->equalTo('id', $pokemonId);

        $sql = new Sql($this->adapter);
        $delete = $sql->delete($this->table);
        $delete->where($where);

        $stmt = $sql->prepareStatementForSqlObject($delete);

        return (bool)$stmt->execute();
    }

    /**
     * @inheritdoc
     */
    public function fetch(int $pokemonId = null) : array
    {
        if (isset($pokemonId)) {
            return $this->fetchOne($pokemonId);
        }

        return $this->fetchAll();
    }

    /**
     * @inheritdoc
     */
    public function fetchOne(int $pokemonId) : array
    {
        $where = new Where();
        $where->equalTo('id', $pokemonId);

        $sql = new Sql($this->adapter);
        $select = $sql->select($this->table);
        $select->columns(['*'])
            ->where($where);

        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        return $result->getResource()->fetchAll();
    }

    /**
     * @inheritdoc
     */
    public function fetchAll()
    {
        $sql = new Sql($this->adapter);
        $select = $sql->select($this->table);
        $select->columns(['*']);

        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        return $result->getResource()->fetchAll();
    }

    public function load(int $pokemonId, string $column = null, array $attributes = null)
    {

    }

    /**
     * @return array
     */
    public function getFillables() : array
    {
        return $this->fillables;
    }
}
