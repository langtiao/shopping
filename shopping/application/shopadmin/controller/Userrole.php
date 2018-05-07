<?php
namespace app\shopadmin\controller;

use think\Controller;
use think\Db;
class Userrole extends Controller
{
    public function setUser()
    {
    	if(request()->isGet())
    	{
    		//获取传过来的权限Id
    	$role_id=input('get.role_id');

    	//根据权限Id获取角色的ID
    	$user_id = DB::table('user_role')->where('role_id','in',$role_id)->column('user_id');
    	if(empty($user_id))
    	{
    		$user_id=array(0);
    	}

    	//通过角色ID来查询用户已分配的权限
    	$userData['in'] = DB::table('admin_user')->where('admin_id','in',$user_id)->select();
    	// $userData['in']=M('user')->where(array('id'=>array('in',$user_id)))->select();
    	//通过角色ID来查询用户未分配的权限
    	$userData['notin'] = DB::table('admin_user')->where('admin_id','not in',$user_id)->select();
    	
    	// $userData['notin']=M('user')->where(array('id'=>array('not in',$user_id)))->select();

    	$userData['role_id']=$role_id;
    	$this->assign('data',$userData);
    	return $this->fetch('set_user');

    	//dump($userData);die;
        //echo "给角色分配用户";
    	}
    	else
    	{

    		$param=input('post.');
    		// dump($param);die;
    		$db=model('user_role');
    		if(empty($param['in']))
    		{
    			$user_id=array(0);
    		}
    		else
    		{
    			$user_id=$param['in'];
    		}
    		$map['role_id']=$param['role_id'];
    		$map['user_id']=array('not in',$user_id);

    		$db->where($map)->delete();
    		if(empty($param['notin']))
    		{
    			$this->success('设置成功');
    		}
    		else
    		{
    			for ($i=0; $i <count($param['notin']) ; $i++) 
	    		{ 
	    			$data[$i]['user_id']=$param['notin'][$i];
	    			$data[$i]['role_id']=$param['role_id'];

	    		}
	    		$db->insertAll($data);
	    		$this->success('设置成功');
	    		//dump($data);die;
    		}

    	}
    }
}