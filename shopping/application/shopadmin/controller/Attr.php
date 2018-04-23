<?php
namespace app\shopadmin\controller;

use think\Controller;
class Attr extends Controller
{
    public function attrlist()
    {
    	//echo "111";die;
        return $this->fetch('attrbute_list');
    }
}