<?php
namespace app\shopadmin\controller;

use think\Controller;
use \think\captcha\Captcha;
class Login extends Controller
{
    public function login()
    {
    	//echo "111";die;
        return $this->fetch('login');
    }
}