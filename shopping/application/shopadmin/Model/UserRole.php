<?php
namespace app\shopadmin\model;

use think\Model;
use think\Db;
use think\Request;

class UserRole extends Model
{
	protected $table = "user_role";
    public function getRoleidByUserid($uid)
    {
    	$model = new UserRole;
    	return $role_id = $model->where(['user_id'=>$uid])->column('role_id');
    	//echo "111";die;
    	
    }
}