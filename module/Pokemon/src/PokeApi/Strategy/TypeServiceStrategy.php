<?php

/**
 * Class TypeServiceStrategy
 *
 * @package             Pokemon\PokeApi\Strategy
 * @author              Didier Youn <didier.youn@gmail.com>, Marc Intha-Amnouay <marc.inthaamnouay@gmail.com>, Antoine Renault <antoine.renault.mmi@gmail.com>
 * @copyright           Copyright (c) 2017 Tinwork
 * @license             http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link                https://github.com/Tinwork/ZendPokemon
 */
namespace Pokemon\PokeApi\Strategy;

use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;

use Pokemon\Common\Model\Resource\Type;
use Pokemon\Common\Strategy\AbstractRestApiServiceStrategy;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;

use Pokemon\PokeApi\Controller\PokemonController;

class TypeServiceStrategy extends AbstractRestApiServiceStrategy
{
    /** @var string PUBLIC_BADGE_SERVER_PATH */
    const PUBLIC_BADGE_SERVER_PATH = DS . 'public' . DS . 'img' . DS . 'badges' . DS;
    /** @var string PUBLIC_BADGE_DIRECTORY */
    const PUBLIC_BADGE_DIRECTORY = DS . 'img' . DS . 'badges' . DS;
    /** @var Type $resource */
    protected $resource;

    /**
     * TypeServiceStrategy constructor.
     *
     * @param Type $resource
     */
    public function __construct(Type $resource)
    {
        $this->resource = $resource;
    }

    /**
     * Fetch one or all types
     *
     * @param int|null $typeId
     * @return array
     */
    public function fetch(int $typeId = null) : array
    {
        return $this->__r([
            'types' => $this->resource->fetch($typeId)
        ]);
    }

    /**
     * Fetch pokemons by types
     *
     * @param int $typeId
     * @param array|null $queries
     * @return array
     */
    public function fetchPokemonsByType(int $typeId, array $queries = null) : array
    {
        return $this->__r([
            'type' => $this->resource->load($typeId),
            'pokemons' => $this->resource->fetchPokemonsByType($typeId, $queries)
        ]);
    }

    /**
     * Get all badges or associated badge by types
     *
     * @param array|null $types
     * @return array
     */
    public function fetchBadgesType(array $types = null) : array
    {
        $badgeFolder = getcwd() . self::PUBLIC_BADGE_SERVER_PATH;
        if (!is_dir($badgeFolder)) {
            return [];
        }
        $files = array_diff(scandir($badgeFolder), ['.', '..']);
        $result = [];
        if ($types && is_array($types) && sizeof($types) > 1) {
            foreach ($files as $file) {
                preg_match('/^(?P<type>[a-zA-Z]+)\.?(?P<extension>png|jpg|gif)$/', $file, $matches);
                if (!isset($matches['type']) || !in_array($matches['type'], $types)) {
                    continue;
                }
                $pathFile = SERVER_HOST . self::PUBLIC_BADGE_DIRECTORY . $file;
                $result[] = [
                    $matches['type'] => $pathFile
                ];
            }

            return $result;
        }
        foreach ($files as $file) {
            preg_match('/^(?P<type>[a-zA-Z]+)\.?(?P<extension>png|jpg|gif)$/', $file, $matches);
            $pathFile = SERVER_HOST . self::PUBLIC_BADGE_DIRECTORY . $file;
            $result[] = [
                $matches['type'] => $pathFile
            ];
        }

        return $result;
    }
}