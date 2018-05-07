<?php
namespace app\shopadmin\controller;

use think\Controller;
use think\Db;
class User extends Controller
{
    public function userlist()
    {
    	//echo "111";die;
    	$data = Db::table('admin_user')->select();
    	$admin_id = DB::table('admin_user')->column('admin_id');
    	foreach ($admin_id as $key => $value) {
    		$role_id = DB::table('user_role')->where(['user_id'=>$value])->column('role_id');
    		$access_id = DB::table('role_access')->where('role_id','in',$role_id)->column('access_id');
    		$access_name = DB::table('access')->where('a_id','in',$access_id)->column('access_name');
    		$a[] = implode(" ",$access_name); 
    	}
    	
    	foreach ($a as $key => $value) {
    		$data[$key]['access_name'] = $a[$key];
    	}
     //    $data->paginate(1,5);

    	// var_dump($data);die;
    	$this->assign('data',$data);
        return $this->fetch('user_list');
    }
    public function useradd(){
    	return $this->fetch('user_add');
    }

}