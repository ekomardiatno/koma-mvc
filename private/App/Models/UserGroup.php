<?php
namespace App\Models;
use App\Wrapper\Model;
use App\Helpers\Auth;
class UserGroup extends Model
{

  protected $_table_name = 'core_user_group';
  protected $_primary_key = 'user_group_id';

  public function group_user_loggedin()
  {
    for ($i = 0; $i < count(Auth::user('user_groups')); $i++) :
      $params_group[] = [
        'column' => 'user_group_id',
        'value' => Auth::user('user_groups')[$i],
        'conjunction' => $i === count(Auth::user('user_groups')) - 1 ? 'AND' : 'OR'
      ];
    endfor;
    $params_group[] = [
      'column' => 'status',
      'value' => 1
    ];
    $user_group = $this->_db->select('user_group_access,user_group_modify,user_group_publish', ['where' => $params_group], 'RESULT_ARRAY');
    if (!$user_group['status']) return printf($user_group['error_msg']);
    $user_group = $user_group['data'];
    $user_group_access = [];
    $user_group_modify = [];
    $user_group_publish = [];
    foreach ($user_group as $g) {
      $user_group_access = array_merge($user_group_access, unserialize($g['user_group_access']));
      $user_group_modify = array_merge($user_group_modify, unserialize($g['user_group_modify']));
      $user_group_publish = array_merge($user_group_publish, unserialize($g['user_group_publish']));
    }

    return [
      'user_group_access' => $user_group_access,
      'user_group_modify' => $user_group_modify,
      'user_group_publish' => $user_group_publish
    ];
  }

}