<?php

/**
 * Class Resource
 *
 * @package             Pokemon\Common\Model\Resource
 * @author              Didier Youn <didier.youn@gmail.com>, Marc Intha-Amnouay <marc.inthaamnouay@gmail.com>, Antoine Renault <antoine.renault.mmi@gmail.com>
 * @copyright           Copyright (c) 2017 Tinwork
 * @license             http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link                https://github.com/Tinwork/ZendPokemon
 */
namespace Pokemon\Common\Model\Resource;

use Zend\Db\Adapter\AdapterAwareTrait;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Where;
use Zend\Json\Json as Zend_Json;

class Resource
{
    use AdapterAwareTrait;

    /** @var string $table */
    protected $table = "table";

    /**
     * Load object by id
     *
     * @param int $id
     * @param string|null $table
     * @return array
     */
    public function load(int $id, $table = null)
    {
        if (!isset($table)) {
            $table = $this->table;
        }
        $sql = new Sql($this->adapter);
        $where = new Where();
        $where->equalTo('id', $id);
        $select = $sql->select($table);
        $select->columns(['*'])
            ->where($where);

        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        $rows = $this->render($result->getResource()->fetchAll());

        return $rows ? reset($rows) : [];
    }

    public function loadByAttribute(... $args)
    {
        foreach ($args as $key => $arg) {
            if (!is_array($arg)) { $args[$key] = [$arg]; }
        }
        /** @var array $attributes */
        $attributes = $args[1];
        $sql = new Sql($this->adapter);
        $where = new Where();
        $select = $sql->select($this->table);
        foreach ($attributes as $column => $attribute) {
            $where->like($column, '%' . $attribute . '%');
        }
        $select->columns(['*'])->where($where);
        $stmt = $sql->prepareStatementForSqlObject($select);
        $result = $stmt->execute();

        return $this->render($result->getResource()->fetchAll());
    }

    /**
     * Format data before render
     *
     * @param array $data
     * @return array
     */
    protected function render($data) : array
    {
        if (!$data) {
            return [];
        }
        /** @var array $result */
        $result = [];
        /** @var int $index */
        $index = 0;
        foreach ($data as $object) {
            $result[$index] = [];
            foreach ($object as $key => $attribute) {
                if (is_int($key) || !isset($attribute)) {
                    continue;
                }
                $result[$index][$key] = $attribute;
            }
            $index++;
        }

        return $result;
    }

    /**
     * Check if attributes is save as JSON
     *
     * @param $string
     * @return bool
     */
    private function isJson($string)
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
}