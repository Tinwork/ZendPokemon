<?php

/**
 * Class GeoPosition
 *
 * @package             Pokemon\Common\Model\Resource
 * @author              Didier Youn <didier.youn@gmail.com>, Marc Intha-Amnouay <marc.inthaamnouay@gmail.com>, Antoine Renault <antoine.renault.mmi@gmail.com>
 * @copyright           Copyright (c) 2017 Tinwork
 * @license             http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link                https://github.com/Tinwork/ZendPokemon
 */
namespace Pokemon\Common\Model\Resource;

use Pokemon\Common\Model\Facade\GeoPositionFacade;
use Pokemon\Common\Model\Resource\Resource;
use Pokemon\PokeApi\Strategy\PokemonServiceStrategy as PokemonStrategy;
use Zend\Db\Adapter\AdapterAwareTrait;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Where;

class GeoPosition extends Resource implements GeoPositionFacade
{
    use AdapterAwareTrait;
    /** @var string $table */
    protected $table = "positions";
    /** @var array $fillables */
    protected $fillables = ["long", "lat", "pokemon_id"];

    /**
     * @inheritDoc
     */
    public function fetch(int $typeId): array
    {
        // TODO: Implement fetch() method.
    }

    /**
     * @inheritDoc
     */
    public function fetchOne(int $typeId): array
    {
        // TODO: Implement fetchOne() method.
    }

    /**
     * @inheritDoc
     */
    public function fetchAll()
    {
        // TODO: Implement fetchAll() method.
    }

    public function radar($longitude, $latitude, $rayon, $pokemonId = null)
    {
        $pokemonList = [
            'radar' => [
                'longitude' => $longitude,
                'latitude'  => $latitude
            ],
            'result' => []
        ];

        try {
            $sql = new Sql($this->adapter);
            $where = new Where();
            $where->between('longitude', $longitude - $rayon - 0.0001, $longitude + $rayon + 0.0001);
            $where->between('latitude', $latitude - $rayon - 0.0001, $latitude + $rayon + 0.0001);
            if ($pokemonId) {
                $where->equalTo('pokemon_id', $pokemonId);
            }
            $select = $sql->select($this->table);
            $select->columns(['*'])
                ->where($where);

            $stmt = $sql->prepareStatementForSqlObject($select);
            $result = $stmt->execute();

            $rows = $result->getResource()->fetchAll();
            $pokemonList['result'] = $result->getAffectedRows();
            foreach ($rows as $row) {
                if (!isset($row['pokemon_id'])) {
                    continue;
                }
                $pokemonId = $row['pokemon_id'];
                $pokemon = $this->load($pokemonId, 'pokemons');
                $pokemonList['collection'][] = [
                    'pokemon'   => [
                        'icon'      => $this->getIcon($pokemon),
                        'position'  => $this->getPosition($pokemon)
                    ]
                ];
            }

        } catch (\Exception $e) {
            return [
                "value" => $e->getMessage()
            ];
        }

        return $pokemonList;
    }

    /**
     * @inheritDoc
     */
    public function save(int $pokemonId, array $position) : array
    {
        try {
            $sql = new Sql($this->adapter);
            $insert = $sql->insert($this->table)
                ->values([
                    'pokemon_id' => $pokemonId,
                    'longitude' => $position['longitude'],
                    'latitude' => $position['latitude'],
                ]);

            $statement = $sql->prepareStatementForSqlObject($insert);
            $result = $statement->execute();
        } catch (\Exception $e) {
            return [
                "error" => $e->getMessage()
            ];
        }

        return [
            "value" => $result->getGeneratedValue()
        ];
    }

    /**
     * @inheritDoc
     */
    public function delete(int $typeId): bool
    {
        $sql = new Sql($this->adapter);

        $where = new Where();
        $where->equalTo('id', $typeId);

        $delete = $sql->delete($this->table);
        $delete->where($where);

        $stmt = $sql->prepareStatementForSqlObject($delete);
        $res = $stmt->execute();

        return (int)$res->getAffectedRows() == 1 ? true : false;
    }

    /**
     * Get pokemon icon
     *
     * @param array|null $pokemon
     * @return null|string
     */
    private function getIcon(array $pokemon = null)
    {
        if (!$pokemon) {
            return null;
        }
        $rank = $pokemon['rank'];
        $iconPath = PokemonStrategy::ICON_FOLDER .  str_pad($rank, 3, 0, STR_PAD_LEFT) . '.' . PokemonStrategy::ICON_EXTENSION;
        $absolutePath = ROOT_PATH . $iconPath;

        return !file_exists($absolutePath) ? null : SERVER_HOST . $iconPath;
    }

    /**
     * Get long/lat from pokemon
     *
     * @param array $pokemon
     * @return array
     */
    private function getPosition(array $pokemon) : array
    {
        if (!$pokemon || !isset($pokemon['id'])) {
            return [];
        }
        $pokemonId = $pokemon['id'];
        try {
            $sql = new Sql($this->adapter);
            $select = $sql->select($this->table);
            $where = new Where();
            $where->equalTo('pokemon_id', $pokemonId);
            $select->columns(['*'])
                ->where($where);

            $stmt = $sql->prepareStatementForSqlObject($select);
            $result = $stmt->execute();

            return $this->render($result->getResource()->fetch());
        } catch (\Exception $e) {
            return [];
        }
    }
}