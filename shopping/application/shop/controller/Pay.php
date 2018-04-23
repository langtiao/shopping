<?php
namespace app\shop\controller;

use think\Controller;
class Pay extends Controller
{
    public function pay()
    {
        
        return $this->fetch('pay');
    }
    public function register(){
        return $this->fetch('register');
    }
    public function listja(){
        return "aaa";
    }
}