<?php
namespace app\shop\controller;

use think\Controller;
use app\shop\controller\Base;
use think\Session;
class Home extends Base
{
    public function index()
    {
    	//获取用户名
    	/*$userinfo=Session::get('userinfo');
    	$username=$userinfo['nickname']?$userinfo['nickname']:'';
    	$this->assign('username',$username);*/

        return $this->fetch('index');
    }
}