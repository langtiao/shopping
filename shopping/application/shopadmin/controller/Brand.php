<?php
namespace app\shopadmin\controller;

use think\Controller;
class Brand extends Controller
{
    public function brandlist()
    {

        return $this->fetch('brand_list');
    }
}