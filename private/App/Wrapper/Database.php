<?php

/**
 * Created by Eko Mardiatno.
 * Copyright 2018 KOMA MVC. All Right Reserved.
 * Instagram @komafx
 * Licensed under MIT (https://github.com/ekomardiatno/koma-mvc/blob/master/LICENSE)
 */

namespace App\Wrapper;

use PDO;
use PDOException;

class Database
{

    private static $_instance = null;

    private $mysqli,
        $table;

    public function __construct()
    {
        $this->mysqli = new \mysqli(getenv('DB_HOST'), getenv('DB_USERNAME'), getenv('DB_PASSWORD'), getenv('DB_DATABASE'));

        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
    }

    public static function getPDOInstance()
    {
        $dsn = "mysql:host=" . getenv('DB_HOST') . ";dbname=" . getenv('DB_DATABASE') . ";charset=UTF8";
        try {
            $conn = new PDO($dsn, getenv('DB_USERNAME'), getenv('DB_PASSWORD'), [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
            return $conn;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function getInstance()
    {

        if (!isset(self::$_instance)) {

            self::$_instance = new Database;
        }

        return self::$_instance;
    }

    public function table($table)
    {

        $this->table = $table;
    }

    /* ================================================================
     * $fields = 'column1,column2,column3'

     * $where = [
     *     'params' => [
     *        [
     *           'column' => 'column1',
     *           'value' => 'value1',
     *           'operator' => '=/!=/LIKE/>=/<=',
     *           'conjunction' => 'OR/AND,
     *        ],
     *        [
     *           'column' => 'column2',
     *           'value' => 'value2',
     *           'operator' => '=/!=/LIKE/>=/<=',
     *           'conjunction' => 'OR/AND,
     *        ]
     *     ],
     *     'order_by' => ['column1', 'DESC/ASC'],
     *     'limit' => [start,length]
     * ];
     * ================================================================
     */
    public function select($fields = null, $where = null, $fetch = 'RESULT_ARRAY')
    {

        $table = '`' . $this->table . '`';
        $sql = 'SELECT ';
        if ($fields !== null) {
            $fields = explode(',', $fields);
            foreach ($fields as $value) {
                $sql .= $value . ',';
            }
        } else {
            $sql .= '* ';
        }

        $sql = substr($sql, 0, -1) . ' FROM ' . $table;


        $sql = $this->where($where, $sql);

        $data = $this->fetch($sql, $fetch);

        return $data;
    }

    /* ======================================================
     *   $fields = [
     *       'table1' => 'column1,column2,column3',
     *       'table2' => 'column2'
     *   ];
     *
     *   $index = [
     *       'table2' => ['index_table' => 'table1', 'index_id' => 'index12', 'joined_by' => 'INNER JOIN/OUTER JOIN/LEFT JOIN/RIGHT JOIN']
     *   ];
     *
     *   $where = [
     *       'params' => [
     *           [
     *              'column' => 'table.column',
     *              'value' => 'data'
     *           ]
     *       ],
     *       'order_by' => ['table.column', 'ASC/DESC'],
     *       'limit' => [0,1]
     *   ];
     *
     *  $model->join($fields, $index, $where);
     * =======================================================
    */
    public function join($fields = null, $index = [], $where = null, $fetch = 'RESULT_ARRAY')
    {
        $table = '`' . $this->table . '`';
        $sql = 'SELECT ';
        if ($fields !== null) {
            foreach ($fields as $key => $value) {
                $value = explode(',', $value);
                for ($i = 0; $i < count($value); $i++) {
                    $sql .= $key . '.' . $fields[$key][$i] . ',';
                }
            }
        } else {
            $sql .= '* ';
        }
        $sql = substr($sql, 0, -1) . ' FROM ' . $table;

        foreach ($index as $key => $value) {
            $sql .= ' ' . $value['joined_by'] . ' ' . $key . ' ON ' . $value['index_table'] . '.' . $value['index_id'] . '=' . $key . '.' . $value['index_id'];
        }

        $sql = $this->where($where, $sql);

        $data = $this->fetch($sql, $fetch);

        return $data;
    }

    /* =======================================================
     * $data = [
     *     'column1' => 'value1',
     *     'column2' => 'value2',
     *     'column3' => 'value3'
     * ];
     * =======================================================
     */
    public function insert($data, $fetch = null)
    {

        $table = '`' . $this->table . '`';
        $sql = 'INSERT INTO ' . $table . '(';
        foreach ($data as $key => $value) {
            $sql .= $key . ', ';
        }
        $sql = substr($sql, 0, -2) . ') VALUES(';
        foreach ($data as $key => $value) {
            $sql .= '\'' . $value . '\', ';
        }
        $sql = substr($sql, 0, -2) . ')';

        if ($fetch != null && $fetch == 'SQL') {
            return $sql;
            die;
        }

        if ($this->mysqli->query($sql)) {
            return ['status' => true];
        } else {
            return ['status' => false, 'error_msg' => $this->mysqli->error, 'error_code' => $this->mysqli->errno];
        }
    }

    /* =======================================================
     * $data = [
     *     'column1' => 'value1',
     *     'column2' => 'value2',
     *     'column3' => 'value3'
     * ];
     * 
     * $where = [
     *     'params' => [
     *        [
     *           'column' => 'column1',
     *           'value' => 'value1',
     *           'operator' => '=/!=/LIKE/>=/<=',
     *           'conjunction' => 'OR/AND,
     *        ],
     *        [
     *           'column' => 'column2',
     *           'value' => 'value2',
     *           'operator' => '=/!=/LIKE/>=/<=',
     *           'conjunction' => 'OR/AND,
     *        ]
     *     ]
     * ];
     * =======================================================
     */
    public function update($data = [], $where, $fetch = null)
    {

        $table = '`' . $this->table . '`';
        $sql = "UPDATE " . $table . " SET ";
        foreach ($data as $key => $value) {
            $sql .= '`' . $key . '`' . "='" . $value . "', ";
        }
        $sql = substr($sql, 0, -2);

        $sql = $this->where($where, $sql);

        if ($fetch != null && $fetch == 'SQL') {
            return $sql;
            die;
        }

        if ($this->mysqli->query($sql)) {
            return ['status' => true];
        } else {
            return ['status' => false, 'error_msg' => $this->mysqli->error, 'error_code' => $this->mysqli->errno];
        }
    }

    public function delete($where = null, $fetch = null)
    {

        $table = '`' . $this->table . '`';
        $sql = "DELETE FROM " . $table;

        $sql = $this->where($where, $sql);

        if ($fetch != null && $fetch == 'SQL') {
            return $sql;
            die;
        }

        if ($this->mysqli->query($sql)) {
            return ['status' => true];
        } else {
            return ['status' => false, 'error_msg' => $this->mysqli->error, 'error_code' => $this->mysqli->errno];
        }
    }

    public function query($sql, $fetch = 'RESULT_ARRAY')
    {

        $data = $this->fetch($sql, $fetch);

        return $data;
    }

    private function where($where, $sql)
    {

        if (is_array($where)) {

            if (isset($where['data_id'])) {

                $sql .= " WHERE id_" . $this->table . "='" . $where['data_id'] . "'";
            }

            if (isset($where['params'])) {

                $sql .= ' WHERE';
                foreach ($where['params'] as $p) {
                    $operator = '=';
                    $conjunction = 'AND';
                    $value = $p['value'];
                    if (isset($p['operator'])) {
                        $operator = $p['operator'];
                        if ($operator == 'LIKE') {
                            $operator = ' LIKE ';
                            $value = '%' . $value . '%';
                        }
                    }
                    if (isset($p['conjunction'])) {
                        $conjunction = $p['conjunction'];
                    }
                    $sql .= ' ' . $p['column'] . $operator . '"' . $value . '"' . ' ' . $conjunction;
                }

                $sql = substr($sql, 0, -1);

                $conjunction = isset($where['params'][count($where['params']) - 1]['conjunction']) ? $where['params'][count($where['params']) - 1]['conjunction'] : 'AND';

                switch ($conjunction) {
                    case 'AND':
                        $sql = substr($sql, 0, -3);
                        break;
                    case 'OR':
                        $sql = substr($sql, 0, -2);
                        break;
                }
            }

            if (isset($where['order_by'])) {

                $sql .= ' ORDER BY ' . $where['order_by'][0] . ' ' . $where['order_by'][1];
            }

            if (isset($where['limit'])) {

                $sql .= ' LIMIT ' . $where['limit'][0] . ',' . $where['limit'][1];
            }
        }

        return $sql;
    }

    private function fetch($sql, $fetch)
    {

        $data = [];
        $query = $this->mysqli->query($sql);
        if (!$query) {
            return ['status' => false, 'error_msg' => $this->mysqli->error, 'error_code' => $this->mysqli->errno];
        }
        switch ($fetch) {
            case 'ROW_ARRAY':
                $row = $query->fetch_assoc();
                $data = $row;
                break;
            case 'RESULT_ARRAY':
                while ($row = $query->fetch_assoc()) {
                    $data[] = $row;
                }
                break;
            case 'NUM_ROWS':
                $data = $query->num_rows;
                break;
            case 'SQL':
                $data = $sql;
                break;
            case 'BOOLEAN':
                $data = $query;
                break;
        }

        return ['status' => true, 'data' => $data];
    }
}
