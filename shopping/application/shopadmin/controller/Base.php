<?php
namespace app\shopadmin\controller;

use think\Controller;
class Base extends Controller
{
    public function _initialize() {
    	//parent::initialize();
    	session('uid',1);
        $uid=session('uid');
    	if(!$uid)
    	{
    		$this->error('请先登录','/shopadmin/login/login');
    	}
    	//判断是否拥有操作权限
    	$module = request()->module();
        $controller = request()->controller();
        $action = request()->action(); 
    	$accessUrl=$module.'/'.$controller.'/'.$action;
    	//if(strcasecmp($val1,$val2)==0)
    	//echo $accessUrl;die;
        if($accessUrl!='shopadmin/Index/index'&&$uid!=2)
        {
    	   $accessUrls=$this->checkAccess($uid);
        	if(!in_array($accessUrl,$accessUrls))
        	{
        		$this->error('你的权限不够','/static/shopadmin/main.html');
        	}
        }
    }
    public function checkAccess($uid)
        {

        	$model = model('UserRole');
        	$role_id = $model->getRoleidByUserid(1);
        	
        	
            //根据用户名的主键ID查询用户与角色的关联表 获取用户所拥有的角色的ID

            if(empty($role_id))
            {
                $role_id=array(0);
            }
            //根据角色ID 查询角色与权限的关联表 获取用户所拥有的权限ID
            $access_id = model('RoleAccess')->getAccessidByRoleid($role_id);
            if (empty($access_id)) 
            {
                $access_id=array(0);
            }
            //dump($accessId);die;
            //根据权限ID查询权限表 获取用户所能访问的控制器与方法
            $access_url = model('Access')->getUserurlByAccessid($access_id);
            return $access_url;
            //dump($accessUrls);die;
        }
}