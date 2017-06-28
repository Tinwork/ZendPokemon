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
    protected $fillables = ["name", "rank"];
    /** @var array $uniques */
    protected $uniques = ["name", "rank"];

    /**
     * @inheritdoc
     */
    public function save(array $data, string $path = null) : bool
    {
        $sql = new Sql($this->adapter);
        $insert = $sql->insert($this->table)
            ->values([
                'name'          => $data['name'],
                'rank'          => $data['rank'],
                'type_id'       => $data['type'],
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
        $res = $stmt->execute();

        return (int)$res->getAffectedRows() == 1 ? true : false;
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
            $pokemons[$index] = $this->loadExtraAttributes($pokemon);
        }

        return $this->render($pokemons);
    }

    private function loadExtraAttributes($pokemon)
    {
        if (isset($pokemon['evolutions'])) {
            $pokemon['evolutions'] = $this->loadEvolutions($pokemon);
        }
        if (isset($pokemon['type_id'])) {
            $pokemon['type_id'] = $this->loadType($pokemon);
        }
        if (array_key_exists('thumbnail', $pokemon) && isset($pokemon['thumbnail'])) {
            $pokemon['thumbnail'] = $this->loadThumbnailPath($pokemon);
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
                $evol = $this->loadByAttribute('rank', [
                    'rank' => $rankToLoad
                ]);
                if ($evol && is_array($evol)) {
                    $evol = reset($evol);
                }
                $resultEvolution[$key][] = $evol;
            }
        }
        foreach ($resultEvolution as $key => $result) {
            if (!is_array($result)) {
                continue;
            }
            if (sizeof(reset($result)) < 1) {
                $resultEvolution[$key] = [];
                continue;
            }
            foreach ($result as $index => $tmpResult) {
                if (isset($tmpResult['evolutions'])) {
                    unset($tmpResult['evolutions']);
                }
                if (isset($tmpResult['type_id'])) {
                    $tmpResult['type_id'] = $this->loadType($tmpResult);
                }
                $result[$index] = $tmpResult;
            }

            $resultEvolution[$key] = $result;
        }

        return $resultEvolution;
    }

    private function loadType($pokemon)
    {
        if (!isset($pokemon['type_id'])) {
            return $pokemon;
        }
        $pokemonTypeId = $pokemon['type_id'];
        $types = explode(',', $pokemonTypeId);
        $result = [];
        foreach ($types as $type) {
            $typeEntity = $this->load($type, 'types');
            if (!$typeEntity) {
                continue;
            }
            $result[] = [
                'label' => $typeEntity['label'],
                'badge_path' => null,
                'color' => null
            ];
        }
        if (sizeof($result) <= 1) {
            $result = reset($result);
        }

        return $result;
    }

    /**
     * Get thumbnail from pokemon
     *
     * @param array $pokemon
     * @return null|string
     */
    private function loadThumbnailPath(array $pokemon)
    {
        return isset($pokemon['thumbnail']) ? SERVER_HOST . $pokemon['thumbnail'] : null;
    }

}
