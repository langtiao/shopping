<?php
namespace app\shop\controller;

use think\Controller;
use think\Session;
use think\Cookie;
use think\Db;

class Base extends Controller{
    public function _initialize(){
       
        if(!Session::has('user_id')&&Cookie::has('user_id')){
        	$uid=Cookie::get('user_id');
        	Session::set('user_id',$uid);



        }
       
        if(!Session::has('user_id')){

        	$this->redirect('login/login');
        }else{
        	$uid=Session::get('user_id');
        	$userinfo=Db::table('user')->where('user_id',$uid)->find();
        	Session::set('userinfo',$userinfo);
        	

        }
    }
}