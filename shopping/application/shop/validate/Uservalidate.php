<?php 
namespace app\shop\validate;

use think\Validate;
use app\shop\model\User;

class Uservalidate extends Validate
{
    protected $rule = [
        'email'=>'require|unique:User',
        'mobile'=>'require|unique:User|mobile',
        'code'=>'require|captcha',
        'oldpwd'=>'require',
        'pwd' =>  'require|min:8|max:25',
        'zhanghao'=>'require',
        'loginpwd'=>'require',
        
        
        'confirm_pwd'=>'confirm:pwd',
    ];
     protected $message = [
     	'email.require'=>'邮箱不能为空',
     	'email.unique'=>'邮箱已经存在',
     	'mobile.require'=>'手机号不能为空',
     	
     	'mobile.unique'=>'对不起，该手机号已经被使用',
        'mobile.mobile'=>'对不起手机号格式不对',
     	'code.require'=>'请输入验证吗',
     	'code.captcha'=>'验证码不正确',
     	
        'pwd.require'  =>  '密码必须',
        'pwd.min'=>'密码最少八位',
        'pwd.max'=>'密码最多25位',
        'zhanghao.require'=>'请输入您的账号',
        'loginpwd.require'=>'账号不能为空',
        'oldpwd.require'=>'请输入原密码',
        'confirm_pwd.confirm' =>  '确认密码与密码不一致',
    ];
    protected $regex = [
        'mobile'    => '/^1[2|3|4|5|8]\d{9}$/',
        
    ];
     protected $scene = [
        'email'  =>  ['email','pwd','confirm_pwd'],
        'mobile'=>['mobile','pwd','confirm_pwd','code'],
        'login'=>['zhanghao','loginpwd'],
        'changepwd'=>['oldpwd','pwd','confirm_pwd'],
    ];

  

 
    
   
}

 ?>