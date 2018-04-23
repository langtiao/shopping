<?php
namespace app\shopadmin\controller;

use think\Controller;
class Cat extends Controller
{
    public function catlist()
    {
    	//echo "111";die;
        return $this->fetch('cat_list');
    }
}