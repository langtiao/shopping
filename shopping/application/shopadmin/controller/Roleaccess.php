<?php
namespace app\shopadmin\controller;

use think\Controller;
use think\Db;
class Roleaccess extends Controller
{
    public function setAccess()
    {
    	if(request()->isGet())
    	{
    		//获取传过来的权限Id
    	$role_id=input('get.role_id');

    	//根据权限Id获取角色的ID
    	$access_id = DB::table('role_access')->where('role_id','in',$role_id)->column('access_id');
    	if(empty($access_id))
    	{
    		$access_id=array(0);
    	}

    	//通过角色ID来查询用户已分配的权限
    	$accessData['in'] = DB::table('access')->where('a_id','in',$access_id)->select();
    	// $userData['in']=M('user')->where(array('id'=>array('in',$user_id)))->select();
    	//通过角色ID来查询用户未分配的权限
    	$accessData['notin'] = DB::table('access')->where('a_id','not in',$access_id)->select();
    	
    	// $userData['notin']=M('user')->where(array('id'=>array('not in',$user_id)))->select();

    	$accessData['role_id']=$role_id;
    	$this->assign('data',$accessData);
    	return $this->fetch('set_access');

    	//dump($userData);die;
        //echo "给角色分配用户";
    	}
    	else
    	{

    		$param=input('post.');
    		// dump($param);die;
    		$db=model('role_access');
    		if(empty($param['in']))
    		{
    			$access_id=array(0);
    		}
    		else
    		{
    			$access_id=$param['in'];
    		}
    		$map['role_id']=$param['role_id'];
    		$map['access_id']=array('not in',$access_id);

    		$db->where($map)->delete();
    		if(empty($param['notin']))
    		{
    			$this->success('设置成功');
    		}
    		else
    		{
    			for ($i=0; $i <count($param['notin']) ; $i++) 
	    		{ 
	    			$data[$i]['access_id']=$param['notin'][$i];
	    			$data[$i]['role_id']=$param['role_id'];

	    		}
	    		$db->insertAll($data);
	    		$this->success('设置成功');
	    		//dump($data);die;
    		}

    	}
    }
}