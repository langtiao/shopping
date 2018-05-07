<?php
namespace app\shopadmin\controller;

use think\Controller;
use think\Db;
class Cat extends Controller
{
    public function catlist()
    {	
    	$user = model("Cat");
    	$res = $user->select();
    	$data = $user->category($res,0);   
        // var_dump($data);die;
    	$this->assign('data', $data);
        return $this->fetch('cat_list');
    }
    //添加数据
    public function catadds(){
    	$data = input('post.');
    	$user = model("Cat");
    	$res  = $user->insert($data,"cate");
    	if($res){
    		$this->success("添加成功",'Cat/catlist');
    	}
    }    
    //添加页面
    public function cat_add(){
    	$user = model("Cat");
    	$res = $user->select();
        $data = $user->category($res,0);  
    	$this->assign('data', $data);
    	return $this->fetch('cat_add');
    }
    //执行删除
    public function del(){
    	$id = input("get.id");
    	$user = model("Cat");
    	$res = $user->del($id);
    	if($res){
    		$this->success('删除成功');
    	}
    }
    public function up(){
    	$id = input("get.id");
    	$user = model("Cat");
    	$res = $user->upselect($id);
        $result = $user->select();
        $data = $user->category($result,0);
    	$this->assign('data', $data);
        $this->assign('list',$res);
    	return $this->fetch('cat_up');
    }
    public function update(){
        $up_id = input("post.upid");
        $catename = input("post.catename");
        $parent_id = input("post.parent_id");
        $status = input("post.status");
        $data = array(
            'catename'  => $catename,
            'parent_id' => $parent_id,
            'status'    => $status,
        );
        $user = model("Cat");
        $res = $user->up($up_id,$data);
        if($res){
            $this->success("修改成功",'Cat/catlist');
        }
    }
}