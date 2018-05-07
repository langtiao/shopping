<?php
namespace app\shopadmin\controller;

use think\Controller;
use think\File;
use think\Request;


class Brand extends Controller
{
    public function brandlist()
    {	
    	$user = model("brands");
    	$res  = $user->select();
    	$this->assign('res',$res);
        return $this->fetch('brand_list');
    }
    //添加品牌首页
    public function brandadd(){
    	return $this->fetch('brand_add');
    }
    //品牌添加
   	public function add(){
   		$data = input('post.');
   		$file_img = $_FILES['image'];
   		$user = model("brands");  
    	$file_img = $user->upload();
    	$data['b_logo'] = $file_img;
    	$res = $user->insert($data);
    	if($res){
    		$this->success("添加成功",'brand/brandlist');
    	}
   	}
   	//执行删除
   	public function del(){
   		$b_id = input('get.id');
   		$user = model("brands");  
    	$res = $user->del($b_id);
    	if($res){
    		$this->success('删除成功','brand/brandlist');
    	}
   	}
   	//修改页面
   	public function up(){
   		$id = input("get.id");
    	$user = model("brands");
    	$res = $user->upselect($id);
        $this->assign('list',$res);
    	return $this->fetch('brand_up');
   	}
   	public function upadd(){
   		$data = input('post.');
   		$id   = $data['id'];
   		$file_img = $_FILES['image'];
   		$user = model("brands");  
    	$file_img = $user->upload();
    	$data['b_logo'] = $file_img;
    	unset($data['id']);
    	$res = $user->up($id,$data);
    	if($res){
    		$this->success("修改成功",'brand/brandlist');
    	}
   	}
}