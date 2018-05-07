<?php
namespace app\shopadmin\controller;

use think\Controller;
use think\Db;
class Role extends Controller
{
    public function rolelist()
    {
    	//echo "111";die;
    	$data = DB::table('role')->where('r_id','<>',1)->select();
    	$this->assign('data',$data);
        return $this->fetch('role_list');
    }
}