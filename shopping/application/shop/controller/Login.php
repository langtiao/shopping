<?php
namespace app\shop\controller;

use think\Controller;
use \think\Request;
use \think\captcha\Captcha;
use app\shop\model\User;
use \think\Session;
use think\Cookie;
use weibo\SaeAuth;
use weibo\SaeTclientV2;
use app\shop\model\OpenInfo;
use think\Db;

class Login extends Controller
{   

    public $app_key;
    public $app_secret;
    public $back_url;


//实例化控制器的时候回首先加载我们的第三方登录配置
    public function _initialize(){
        $this->app_key = '3395646162';
        $this->app_secret = 'd7f5d968c59d54d25f3fb8110cee6aeb';
        $this->back_url = 'http://www.ayii.com/shop/login/back';
       
    }

    public function login()
    {   
    	if($this->request->isPost()){
             $post= $this->request->post();
          

            $result = $this->validate($post,'Uservalidate.login');
            if(true !== $result){
                // 验证失败 输出错误信息
               $this->assign('errormsg',$result);

            }else{
                $zhanghao=$post['zhanghao'];
                $pwd=$post['loginpwd'];
                //判断有没有该用户
                
              $res =  \think\Db::query("select * from user where email='".$zhanghao."' and pwd='".$pwd."' or mobile='".$zhanghao."' and pwd='".$pwd."'");
              if(!$res){
                 $this->assign('errormsg','用户名或者密码错误');

              }else{

                if(isset($post['rememberMe'])){
                
                    Cookie::set('user_id',$res[0]['user_id'],24*3600);
                }
                
            
                Session::set("user_id",$res[0]['user_id']);


                $this->success('登录成功', '/shop/home/index',2);
              }

                   
            }
        }
           $url="https://api.weibo.com/oauth2/authorize?client_id={$this->app_key}&redirect_uri={$this->back_url}";
         
           $this->assign('weibourl',$url);
        return $this->fetch('login');
    }
    public function register(){
        //header("content-type:text/html;charset=utf-8");

            if($this->request->isPost()){
        $post= $this->request->post();
        $scenario='email';
        if(isset($post['mobile'])){

            $scenario='mobile';
        }
        
      $result = $this->validate($post,'Uservalidate.'.$scenario);
            if(true !== $result){
                // 验证失败 输出错误信息
               $this->assign('errormsg',$result);
            }
           else{

                $user = new User();
                if($scenario=='email'){
                    $user->email=$post['email'];
                }else{
                    $user->mobile=$post['mobile'];
                }
                
                    $user->pwd=$post['pwd'];
                    $user->createtime=date('Y-m-d H:i:s',time());
                    $user->updatetime=date('Y-m-d H:i:s',time());
                    $user->save();
                    $insertid=$user->user_id;
               

                Session::set('user_id',$insertid);
               
             $this->success('注册成功', '/shop/home/index');

            }

        }
    	return $this->fetch('register');
    }
   

   protected function check_verify($code){
    $captcha = new Captcha();
    return $captcha->check($code);
    }

        public function back(){
        //获取code
        $code = $this->request->get('code');
        $sea = new SaeAuth($this->app_key , $this->app_secret);
       
        //根据code获取token
                    if ($code)
                    {
                        $keys = array();
                        $keys['code'] = $code;
                        $keys['redirect_uri'] = $this->back_url;
                      
                            $token = $sea->getAccessToken( 'code', $keys ) ;
                       
                    }

                  
                    //获取到toke你信息后直接存到session里面一遍后面用
                    if ($token){

                                $arr=[];
                                $arr['token'] = [
                                    'access_token'=>$token['access_token'],
                                    'uid'=>$token['uid'],
                                    'lifetime'=> 24*3600 // 这里我设置了一天，你们可以自己设置合适时间
                                ];
                                
                                Session::set('token',$arr['token']);
                        $this->redirect('/shop/login/getuser');
                                }

    }

        //根据token获取用户唯一openid
                public function getuser(){
                    header("content-type:text/html;charset=utf-8");
                        $token = Session::get("token");
                        
                        $c = new SaeTClientV2( $this->app_key , $this->app_secret , $token['access_token'] );
                        $uid_get = $c->get_uid();
                        $uid = $uid_get['uid'];
                        
                        //数据库里面查询是否存在本用户的openid这里获取的是openinfo里面的一整条数据
                        $open_user = Db::table('open_info')
                                        ->where('open_id',$uid)
                                        ->where('type',1)
                                        ->where('status',1)
                                        ->find();
                        if($open_user){

                      
                             
                                 //获取用户信息存入session
                                 $u_id=$open_user['user_id'];
                                

                                Session::set('user_id',$u_id);
                                $this->success('登录成功', '/shop/home/index');

     



                    }
                        //根据openID获取用户等基本信息去到注册表单让用户填写账号信息并绑定账号
                        $user_message = $c->show_user_by_id( $uid);//
                       
                        $this->assign('info',$user_message);
                        //调到注册页面
                      return   $this->fetch('weibologin');


                }

                            //获得用户填写的个人资料信息入库注册并且绑定
    public function bang()
        {
            header("content-type:text/html;charset=utf-8");
          if($this->request->isGet())
            {

                        //因为我们是从邮件链接过来的所以没有的话肯定是非法请求
                        $code=isset($_GET['code'])?$_GET['code']:null;
                        $oid=isset($_GET['oid'])?$_GET['oid']:null;
                        if($code==null || $oid==null)
                        {
                            echo "<script>alert('非法请求');</script>";

                            die;
                        }
                        //查询openinfo判断是登录还是重新登录




                    
                     $open=Db::table('open_info')
                                        ->where('statuscode',$code)
                                        ->where('id',$oid)
                                        ->where('type',1)
                                      
                                        ->find();

                        if($open)
                    {


                            //如果过期则删除这条openinfo数据并且删除发邮件之前与其绑定的admin数据让他调到登录页重新登陆
                            //这里要注意的是我们在激活中的这段时间里面为了防止用户直接拿admin表里的数据登录我们登录的时候需要判断
                            //跟着条admin数据对应的openinfo数据是否激活状态为0表示未激活不让登陆
                            $createtime=$open['create_time'];
                            $time=time();
                            $life=$time-$createtime;
                            if($life>1000)
                            {
                                //删除该openinfo数据和与其对应的admin数据
                               Db::table('open_info')->delete($oid);
                              Db::table('user')->delete($open['user_id']);
                              

                             $this->success('长时间未激活请重新登录', '/shop/login/login',2);
                            }else
                            {
                                //激活openinfo查询该用户的账号信息存session登录成功
                                $open = OpenInfo::get($oid);
                                $open->status    = 1;
                                
                                $open->save();
                               $arr= Db::table('open_info')                                       
                                        ->where('id',$oid)                                      
                                         ->find();

                             
                             Session::set('user_id',$arr['user_id']);
                                        $this->success('激活成功,欢迎来到后台','/shop/home/index',2);

                            }
                    }


            }

            if($this->request->isPost()){
                     /*[name] => tianwnejun
                        [email] =>
                        [pwd] =>
                        [user_headimg] => http://tvax2.sinaimg.cn/crop.227.99.568.568.1024/006XZlhTly8fkfpvu5yd9j30sg0lcans.jpg
                        [open_id] => 6383220657
                        [open_nickname] => tianwnejun*/
                      
                      
                        $email=$_POST['email'];
                        $nickname=$_POST['name'];
                        $pwd=$_POST['pwd'];

                        $model=new User();
                        $model->email=$email;
                         $model->pwd=$pwd;
                          $model->nickname=$nickname;
                          $model->headingimg=isset($_POST['user_headimg'])?$_POST['user_headimg']:'';
                          $model->createtime=date('Y-m-d H:i:s',time());
                          $model->updatetime=date('Y-m-d H:i:s',time());
                          $model->save();




                        



                              $statuscode=uniqid();

                         //绑定
                          $open = new OpenInfo();
                                $open->open_id = $_POST['open_id'];
                                $open->user_id = $model->user_id;//这个admin标的model新增的ID
                                $open->nickname = $_POST['open_nickname'];
                                $open->type = 1; // type=1为微博
                                $open->create_time = time();
                                $open->statuscode=base64_encode($statuscode);
                               
                                    $open->save();
                                    //openinfo标的新增用户ID
                                    $oid=$open->id;
                                    $statuscode=$open->statuscode;
                                    

                           

                         
                            $name='啦啦购物';
                            $subject='第三方登录激活邮箱';
                            $content="<a href='http://www.ayii.com/shop/login/bang?code=".$statuscode."&oid=".$oid."'>"
                                    ."http://www.ayii.com/shop/login/bang"
                                    ."</a>"
                                    ."<br/>请牢记您的账号：$email"
                                    ."<br/>密码：$pwd";
                                
                            $res=sendemail($email,$subject,$content);
                            
                    if($res){
                             return $this->redirect('/shop/login/deng');
                    }else{
                        $this->error('请确认你输入了有效的email地址');
                    }



                



    }


}

public function deng()
{
echo "等待激活中请不要关闭浏览器您需要在1000秒之内前往邮箱激活。。。。。。。。";
}





}