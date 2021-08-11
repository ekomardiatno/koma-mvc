<?php

namespace App\Models;

use App\Wrapper\Model;

class User extends Model
{

  protected $_table_name = 'core_user';
  protected $_primary_key = 'user_id';

  public function get_with_group($username = null, $fetch = 'ROW_ARRAY')
  {
    $fields_user = $username === null ? 'user_id,user_username,user_first_name,user_last_name,user_phone,user_email,user_gender,user_picture,user_id_number,user_id_picture,user_groups,status' : 'user_id,user_username,user_password,user_first_name,user_last_name,user_phone,user_email,user_gender,user_picture,user_id_number,user_id_picture,user_groups,status';
    $fields_user_group = $username === null ? 'user_group_id,user_group_name' : 'user_group_id,user_group_name,user_group_access,user_group_modify,user_group_publish';
    $params = [
      [
        'column' => 'user_username',
        'value' => $username
      ],
      [
        'column' => 'status',
        'value' => '1'
      ]
    ];
    $user = $username === null ? $this->get(null, $fields_user, 'RESULT_ARRAY') : $this->get_by($params, $fields_user, 'RESULT_ARRAY');
    if (!$user['status']) return $user;
    $user = $user['data'];
    $user_ = [];
    foreach ($user as $u) {
      $u['user_groups'] = unserialize($u['user_groups']);
      $params_group = [];
      for ($i = 0; $i < count($u['user_groups']); $i++) :
        $params_group[] = [
          'column' => 'user_group_id',
          'value' => $u['user_groups'][$i],
          'conjunction' => $i === count($u['user_groups']) - 1 ? 'AND' : 'OR'
        ];
      endfor;
      $params_group[] = [
        'column' => 'status',
        'value' => 1
      ];
      $this->_db->table('core_user_group');
      $user_group = $this->get_by($params_group, $fields_user_group, 'RESULT_ARRAY');
      if (!$user_group['status']) return $user_group;
      $user_group = $user_group['data'];
      if($username !== null) {
        $u['user_groups'] = [];
      } else {
        $u['user_groups_name'] = [];
      }
      for ($i = 0; $i < count($user_group); $i++) :
        if($username !== null) {
          $u['user_groups'][] = $user_group[$i]['user_group_id'];
        } else {
          $u['user_groups_name'][] = $user_group[$i]['user_group_name'];
        }
      endfor;
      unset($u['user_group']);
      $user_[] = $u;
    }

    return $fetch === 'ROW_ARRAY' ? ['status' => true, 'data' => $user_[0]] : ['status' => true, 'data' => $user_];
  }
}
