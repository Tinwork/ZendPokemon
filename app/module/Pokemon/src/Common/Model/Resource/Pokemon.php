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
use Pokemon\Common\Model\Resource\Resource;
use Zend\Db\Adapter\AdapterAwareTrait;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Where;
use Zend\Json\Json as Zend_Json;

class Pokemon extends Resource implements PokemonFacade
{
    use AdapterAwareTrait;
    /** @var string $table */
    protected $table = "pokemons";
    /** @var array $fillables */
    private $fillables = ["name", "rank"];
    /** @var array $uniques */
    private $uniques = ["name", "rank"];

    /**
     * @inheritdoc
     */
    public function save(array $data, string $path) : bool
    {
        $sql = new Sql($this->adapter);
        $insert = $sql->insert($this->table)
            ->values([
                'name'          => $data['name'],
                'rank'          => $data['rank'],
                'evolutions'    => $data['evolutions'],
                'thumbnail'     => $path
            ]);

        $statement = $sql->prepareStatementForSqlObject($insert);
        $statement->execute();

        return true;
    }

    /**
     * @inheritdoc
     */
    public function update(int $pokemonId, array $data): bool
    {
        $sql = new Sql($this->adapter);
        $update = $sql->update($this->table);
        $where = new Where();
        $where->equalTo('id', $pokemonId);
        $update->set($data, $where);

        $stmt = $sql->prepareStatementForSqlObject($update);
        $result = $stmt->execute();

        return $result->getAffectedRows() >= 1 ? true : false;
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
            return $this->render($this->fetchOne($pokemonId));
        }

        return $this->render($this->fetchAll());
    }

    /**
     * @inheritdoc
     */
    public function fetchOne(int $pokemonId) : array
    {
        $where = new Where();
        $where->equalTo('rank', $pokemonId);

        $sql = new Sql($this->adapter);
        $select = $sql->select($this->table);
        $select->columns(['*'])
            ->where($where);

        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        $rows = $result->getResource()->fetchAll();

        $pokemon = $this->loadExtraAttributes(reset($rows));

        return $rows ? $this->render([$pokemon]) : [];
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

        $pokemons = $result->getResource()->fetchAll();
        foreach ($pokemons as $index => $pokemon) {
            $pokemons[$index] = $this->loadEvolutions($pokemon);
        }

        return $this->render($pokemons);
    }

    /**
     * @return array
     */
    public function getFillables() : array
    {
        return $this->fillables;
    }

    /**
     * @return array
     */
    public function getUniques() : array
    {
        return $this->uniques;
    }

    private function loadExtraAttributes($pokemon)
    {
        if (isset($pokemon['evolutions'])) {
            //$pokemon = $this->loadEvolutions($pokemon);
        }
        if (isset($pokemon['type_id'])) {
            $pokemon = $this->loadType($pokemon);
        }

        return $pokemon;
    }

    private function loadEvolutions($pokemon)
    {
        if (!isset($pokemon['evolutions'])) {
            return $pokemon;
        }
        $resultEvolution = [];
        $evolutions = Zend_Json::decode($pokemon['evolutions'], true);
        foreach ($evolutions as $key => $evolution) {
            if (!$evolution) {
                continue;
            }
            foreach ($evolution as $rankToLoad) {
                $resultEvolution[$key][] = $this->loadByAttribute('rank', [
                    'rank' => $rankToLoad
                ]);
            }
        }
        $pokemon['evolutions'] = $resultEvolution;

        return $pokemon;
    }

    private function loadType($pokemon)
    {
        if (!isset($pokemon['type_id'])) {
            return $pokemon;
        }
        $pokemonTypeId = $pokemon['type_id'];
        $type = $this->load($pokemonTypeId, 'types');
        $labelType = isset($type['label']) ? $type['label'] : 'Undefined';
        $pokemon['type_id'] = $labelType;

        return $pokemon;
    }
}
