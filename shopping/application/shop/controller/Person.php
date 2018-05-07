<?php 
namespace app\shop\controller;

use think\Controller;
use app\shop\controller\Base;
use think\Session;
use app\shop\model\User;
use app\shop\model\Address;
use app\shop\model\City;

class Person extends Base{

public function index(){

	return $this->fetch('index');


}
public function information(){
	//获取用户详情
	//用户名 昵称姓名 性别生日电话 邮件 
	if($this->request->isPost()){
		$post=$this->request->post();
		 $file = request()->file('newhead');
    
    		if($file){
			$info = $file->move(ROOT_PATH . 'public/uploads');  
		
				if($info){  
				// 成功上传后 获取上传信息  
				$a=$info->getSaveName();  
				$imgp= str_replace("\\","/",$a);  
				$imgpath='/uploads/'.$imgp;  
				$post['headingimg']=$imgpath;
				  
				  
				}else{  
				// 上传失败获取错误信息  
				echo $file->getError();  
				   } 
    		}
    		
		$user = new User();
		$post['updatetime']=date('Y-m-d H:i:s',time());
		// 过滤post数组中的非数据表字段数据
		
		$user->allowField(true)->save($post,['user_id' => $post['user_id']]);

	}
	
	$user_id=Session::get('user_id');
	$user=User::get($user_id);
	$this->assign('user',$user);

	return $this->fetch('information');

}

public function safety(){

	$user_id=Session::get('user_id');
	$user=User::get($user_id);
	$this->assign('user',$user);
	return $this->fetch();
}
public function password()
{
	//获取原密码
	if($this->request->isPost()){
		$post=$this->request->post();
		$user_id=Session::get('user_id');

		$result = $this->validate($post,'Uservalidate.changepwd');
            if(true !== $result){
                // 验证失败 输出错误信息
               $this->assign('errormsg',$result);

            }else{
            				$pwd=$post['oldpwd'];
			                $newpwd=$post['pwd'];
			                //判断有没有该用户
			               	$zhanghao=Session::get("userinfo.email")?Session::get("userinfo.email"):Session::get('userinfo.mobile');
			              
				            $res =  \think\Db::query("select * from user where email='".$zhanghao."' and pwd='".$pwd."' or mobile='".$zhanghao."' and pwd='".$pwd."'");
				              if(!$res){
				                 	$this->assign('errormsg','原密码错误');

				              }else{
				              		$user = new User();
				              		$post['updatetime']=date('Y-m-d H:i:s',time());
									// 过滤post数组中的非数据表字段数据
									$user->allowField(true)->save($post,['user_id' => $user_id]);
									$this->success('修改成功','/shop/login/login',2);

				              }

            }

	}
return $this->fetch();


}

public function bindphone(){

	if($this->request->isPost()){
		$post=$this->request->post();
		print_r($post);die;

	}

	$user_id=Session::get('user_id');
	$user=User::get($user_id);
	$oldphone=$user->bindphone?$user->bindphone:'';
	$this->assign('oldphone',$oldphone);
return $this->fetch();


}
public function address(){
	if($this->request->isPost()){
		$post=$this->request->post();
		$user_id=Session::get('user_id');
		$address          = new Address;
		$address->takename=$post['takename'];
		$address->takemobile=$post['takemobile'];
		$post['sheng']=City::get($post['sheng'])->city_name;
		$post['shi']=City::get($post['shi'])->city_name;
		$post['qu']=City::get($post['qu'])->city_name;
		$address->address=$post['sheng']."省".$post['shi']."市".$post['qu']."区".$post['info'];
		$address->user_id=$user_id;
		$address->save();

	}
	//更改默认
	$a_id=$this->request->get('a_id');
	if($a_id){
		$d_id=$this->request->get('d_id');
		$address = new Address;
		$address->update(['address_id' => $d_id, 'status' => 0]);
		$address->update(['address_id' => $a_id, 'status' => 1]);
	}
	$s_id=$this->request->get('s_id');
	if($s_id){
		$address = Address::get($s_id);
		$address->delete();

	}
	$sheng =  \think\Db::query("select * from shop_city where parent_id=1");
	$this->assign('sheng',$sheng);
	$user_id=Session::get('user_id');
	$address = new Address();
	// 查询数据集
	$addresslist=$address->where('user_id', $user_id)
	    
	    ->select();
	    $this->assign('addresslist',$addresslist);
	return $this->fetch();
}

public function getson(){
	$c_id=$this->request->post('c_id');
	$son =  \think\Db::query("select * from shop_city where parent_id=$c_id");
	echo json_encode($son);

}
public function cardlist(){
	return $this->fetch();
}
public function order(){
	//获取用户所有订单
	
	return $this->fetch();
}
public function change(){
	return $this->fetch();
}
public function comment(){
	return $this->fetch();
}

public function points(){
	return $this->fetch();
}
public function coupon(){
	return $this->fetch();
}
public function bonus(){
	return $this->fetch();
}
public function bill(){
	return $this->fetch();
}
public function collection(){
	return $this->fetch();
}
public function foot(){
	return $this->fetch();
}

}


 ?>