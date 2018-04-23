<?php
namespace app\shopadmin\controller;

use think\Controller;
class Index extends Controller
{
    public function index()
    {
    	//echo "111";die;
        return $this->fetch('index');
    }
}
