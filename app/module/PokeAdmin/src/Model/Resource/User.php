<?php

/**
 * Class User
 *
 * @package             PokeAdmin\Model\Resource
 * @author              Didier Youn <didier.youn@gmail.com>, Marc Intha-Amnouay <marc.inthaamnouay@gmail.com>, Antoine Renault <antoine.renault.mmi@gmail.com>
 * @copyright           Copyright (c) 2017 Tinwork
 * @license             http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link                https://github.com/Tinwork/ZendPokemon
 */
namespace PokeAdmin\Model\Resource;

use PokeAdmin\Model\Resource\Facade\UserInterface;

use Zend\Db\Adapter\AdapterAwareTrait;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Where;

class User implements UserInterface
{
    use AdapterAwareTrait;

    /** @var string $table */
    protected $table = "users";

    /**
     * @inheritdoc
     */
    public function find(string $username, string $password)
    {
        $where = new Where();
        $where->like('username', '%' . $username . '%');
        $where->like('password', '%' . $password . '%');

        $sql = new Sql($this->adapter);
        $select = $sql->select($this->table);
        $select->columns(['*'])
            ->where($where)
            ->limit(1);

        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        $row = $result->getResource()->fetch(\PDO::FETCH_UNIQUE);

        if (isset($row) && sizeof($row) >= 1) {
            return $row;
        }

        return false;
    }
}
