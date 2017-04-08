<?php

/**
 * Class User
 *
 * @package             Pokemon\Common\Model\Resource
 * @author              Didier Youn <didier.youn@gmail.com>, Marc Intha-Amnouay <marc.inthaamnouay@gmail.com>, Antoine Renault <antoine.renault.mmi@gmail.com>
 * @copyright           Copyright (c) 2017 Tinwork
 * @license             http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link                https://github.com/Tinwork/ZendPokemon
 */
namespace Pokemon\Common\Model\Resource;

use Pokemon\Common\Model\Facade\UserFacade;

use Zend\Db\Adapter\AdapterAwareTrait;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Delete;

class User extends Resource implements UserFacade
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

    /**
     * @inheritdoc
     */
    public function create(array $user) : bool
    {
        $sql = new Sql($this->adapter);
        $insert = $sql->insert($this->table);
        $insert->values([
            'username'  => $user['pseudo'],
            'password'  => password_hash($user['password'], PASSWORD_DEFAULT),
            'roles'     => implode(',', $user['roles'])
        ]);

        $statement = $sql->prepareStatementForSqlObject($insert);

        return (bool)$statement->execute();
    }

    /**
     * @inheritdoc
     */
    public function update(int $userId, array $user) : bool
    {
        // TODO: Implement update() method.
    }

    /**
     * @inheritdoc
     */
    public function destroy(int $userId) : bool
    {
        $sql = new Sql($this->adapter);

        $delete = new Delete();
        $delete->from($this->table);
        $delete->where("user_id IN ('SELECT id FROM users WHERE id ='" . $userId. ")");

        $stmt = $sql->prepareStatementForSqlObject($delete);
        //var_dump($stmt->getSql()); die;
        $res = (bool)$stmt->execute();

        var_dump($res);
        die;
        $where->equalTo('id', $userId);

        $delete = $sql->delete($this->table);
        $delete->where($where);

        $stmt = $sql->prepareStatementForSqlObject($delete);

        return (bool)$stmt->execute();
    }

    /**
     * @inheritdoc
     */
    public function fetchAll() : array
    {
        $sql = new Sql($this->adapter);
        $select = $sql->select($this->table);
        $select->columns(['*']);

        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        $rows = $result->getResource()->fetchAll();

        return $this->render($rows);
    }
}
