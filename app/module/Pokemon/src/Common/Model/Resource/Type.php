<?php

/**
 * Class Type
 *
 * @package             Pokemon\Common\Model\Resource
 * @author              Didier Youn <didier.youn@gmail.com>, Marc Intha-Amnouay <marc.inthaamnouay@gmail.com>, Antoine Renault <antoine.renault.mmi@gmail.com>
 * @copyright           Copyright (c) 2017 Tinwork
 * @license             http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link                https://github.com/Tinwork/ZendPokemon
 */
namespace Pokemon\Common\Model\Resource;

use Pokemon\Common\Model\Facade\TypeFacade;
use Pokemon\Common\Model\Resource\Resource;
use Zend\Db\Adapter\AdapterAwareTrait;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Where;

class Type implements TypeFacade
{
    use AdapterAwareTrait;
    /** @var string $table */
    protected $table = "types";
    /** @var array $fillables */
    protected $fillables = ["name"];
    /** @var array $uniques */
    protected $uniques = ["name"];

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

    /**
     * @inheritDoc
     */
    public function save(array $data) : array
    {
        try {
            $sql = new Sql($this->adapter);
            $insert = $sql->insert($this->table)
                ->values([
                    'label' => $data['name']
                ]);
            $statement = $sql->prepareStatementForSqlObject($insert);
            $result = $statement->execute();
        } catch (\Exception $e) {
            return [
                "error" => $e->getMessage()
            ];
        }

        return [
            "value" => (string)$result->getGeneratedValue()
        ];
    }

    /**
     * @inheritDoc
     */
    public function update(int $typeId, array $data): bool
    {
        // TODO: Implement update() method.
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
}