<?php
namespace app\shop\controller;

use think\Controller;
class Login extends Controller
{
    public function login()
    {
    	
        return $this->fetch('login');
    }
    public function register(){
    	return $this->fetch('register');
    }
    public function listja(){
    	return "aaa";
    }
}