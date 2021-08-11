<?php

/**
 * Created by Eko Mardiatno.
 * Copyright 2018 KOMA MVC. All Right Reserved.
 * Instagram @komafx
 * Licensed under MIT (https://github.com/ekomardiatno/koma-mvc/blob/master/LICENSE)
 */
namespace App\Wrapper;
use App\Wrapper\Database;
class Model
{

    protected $_db;
    protected $_table_name = '';
    protected $_primary_key = '';

    public function __construct()
    {

        $this->_db = Database::getInstance();
        $this->_db->table($this->_table_name);
    }

    public function save($post, $id = null, $method = null)
    {
        if ($id === null) {
            return $this->_db->insert($post, $method);
        } else {
            $where = [
                'params' => [
                    [
                        'column' => 'md5(' . $this->_primary_key . ')',
                        'value' => $id
                    ]
                ]
            ];
            return $this->_db->update($post, $where, $method);
        }
    }

    public function get($id = null, $fields = null, $method = 'RESULT_ARRAY')
    {
        $where = null;
        if ($id !== null) {
            $where = [
                'params' => [
                    [
                        'column' => 'md5(' . $this->_primary_key . ')',
                        'value' => $id
                    ]
                ]
            ];
        }
        return $this->_db->select($fields, $where, $method);
    }

    public function get_active($id = null, $fields = null, $method = 'RESULT_ARRAY')
    {
        $where = [
            'params' => [
                [
                    'column' => 'status',
                    'value' => '1'
                ]
            ]
        ];

        if($id !== null) {
            $where['params'][] = [
                'column' => 'md5(' . $this->_primary_key . ')',
                'value' => $id
            ];
        }

        return $this->_db->select($fields, $where, $method);
    }

    public function get_by($params, $fields = null, $method = 'RESULT_ARRAY') {
        if(!$params) {
            return false;
        }
        $where = [
            'params' => $params
        ];

        return $this->_db->select($fields, $where, $method);
    }
    
    public function delete($id, $method = null)
    {

        if(!$id) {
            return false;
        }
        $where = [
            'params' => [
                [
                    'column' => 'md5(' . $this->_primary_key . ')',
                    'value' => $id
                ]
            ]
        ];
        return $this->_db->delete($where, $method);

    }

}
