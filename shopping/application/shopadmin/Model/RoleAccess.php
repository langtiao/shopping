<?php
namespace app\shopadmin\model;

use think\Model;
use think\Db;
use think\Request;

class RoleAccess extends Model
{
	protected $table = "role_access";
    public function getAccessidByRoleid($roleId)
    {
    	$model = new RoleAccess;
    	return $access_id = $model->where('role_id','in',$roleId)->column('access_id');
    	//echo "111";die;
    	
    }
}