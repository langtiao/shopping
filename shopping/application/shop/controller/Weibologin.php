<?php 
namespace app\shop\controller;

use think\Controller;
use \think\Request;

use app\shop\model\User;
use \think\Session;
use think\Cookie;
class Weibologin extends Controller
{
	
	public $app_key;
	public $app_secret;
	public $back_url;


//实例化控制器的时候回首先加载我们的第三方登录配置
	public function _initialize(){
		$this->app_key = '3395646162';
		$this->app_secret = 'd7f5d968c59d54d25f3fb8110cee6aeb';
		$this->back_url = 'http://www.ayii.com/weibologin/callback';
	}
	

	public function actionIndex(){
		
		$model = new LoginForm;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			//做一些有意义的事
			$user=$_POST['LoginForm']['user'];
			$pwd=$_POST['LoginForm']['pwd'];
			$res= Admin::find()->where(['name'=>$user,'pwd'=>$pwd])->asArray()->one();
			if(is_array($res)){
				$session=Yii::$app->session;
				$session['admin']=$res;
				$url=Yii::$app->urlManager->createUrl('admin/index');
				$path= Yii::$app->params['adminpath'];
				 $url=$path.$url;


				echo "<script>alert('登录成功欢迎来到后台');location.href='$url'</script>";



			}else{
				echo "<script>alert('失败')</script>";
				$this->redirect(array('login/index'));
			}


		}else{

			//生成表单页的微博登录跳转链接
				$url="https://api.weibo.com/oauth2/authorize?client_id={$this->app_key}&redirect_uri={$this->back_url}";

			return $this->render('index',['model'=>$model,'url'=>$url]);
		}
	}

	public function actionBack(){
		//获取code
		$code = Yii::$app->request->get('code');

		$sea = new SaeAuth($this->app_key , $this->app_secret);
		//根据code获取token
					if ($code)
					{
					    $keys = array();
					    $keys['code'] = $code;
					    $keys['redirect_uri'] = $this->back_url;
					    try {
					        $token = $sea->getAccessToken( 'code', $keys ) ;
					    } catch (Exception $e) {
					        throw new NotFoundHttpException;
					    }
					}


					//获取到toke你信息后直接存到session里面一遍后面用
					if ($token){
					    		$session = Yii::$app->session;
					            $session['token'] = [
					                'access_token'=>$token['access_token'],
					                'uid'=>$token['uid'],
					                'lifetime'=> 24*3600 // 这里我设置了一天，你们可以自己设置合适时间
					            ];
					   	$this->redirect(Url::toRoute('/login/complete-info'));
								}

	}

		//根据token获取用户唯一openid
				public function actionCompleteInfo(){
						$token = Yii::$app->session->get("token");
						$c = new SaeTClientV2( $this->app_key , $this->app_secret , $token['access_token'] );
						$uid_get = $c->get_uid();
						$uid = $uid_get['uid'];
						//数据库里面查询是否存在本用户的openid这里获取的是openinfo里面的一整条数据
						$open_user = OpenInfo::findOne(['open_id'=>$uid , 'type'=>'1']);
						if($open_user){

						//如果存在直接登录成功直接跳页面
							   /* $user = Admin::findOne($open_user->user_id); // 当open_info信息存在，则直接取其user_id去用户表查询用户信息
							    Yii::$app->user->login($user, 3600 * 24 * 30);*/
							    $url=Yii::$app->urlManager->createUrl('admin/index');
								$path= Yii::$app->params['adminpath'];
								 $url=$path.$url;
								 //获取用户信息存入session
								 $u_id=$open_user['user_id'];
								 $userdata=Admin::findOne($u_id);


									 $session=Yii::$app->session;
									$session['admin']=$userdata;
							    echo "<script>alert('登录成功欢迎来到后台');location.href='$url'</script>";
					}
						//根据openID获取用户等基本信息去到注册表单让用户填写账号信息并绑定账号
						$user_message = $c->show_user_by_id( $uid);//
						//调到注册页面
						return $this->render('weibologin',['info'=>$user_message]);


				}

				//获得用户填写的个人资料信息入库注册并且绑定
	public function actionBang()
{

					if(Yii::$app->request->isGet)
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




			$open = OpenInfo::find()->where(['statuscode'=>$code , 'id'=>$oid, 'type'=>1])->asArray()->one();


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
								$openmodel=new OpenInfo();
								$openmodel->deldata($oid);
								$adminmodel=new Admin();
								$adminmodel->deldata($open['user_id']);

									echo "<script>alert('长时间未激活请重新登录');location.href='http://www.ayii.com/backend/web/index.php?r=login/index'</script>";
									die;
							}else
							{
								//激活openinfo查询该用户的账号信息存session登录成功
								$openmodel = OpenInfo::findOne($oid);
								$openmodel->status = 1;
								$openmodel->save();
								$userdata=Admin::findOne(['id'=>$open['user_id']]);
										 $session=Yii::$app->session;
										$session['admin']=$userdata;
										echo "<script>alert('激活成功欢迎来到后台');location.href='http://www.ayii.com/backend/web/index.php?r=admin/index'</script>";
											die;

							}
					}


			}

			if(Yii::$app->request->isPost){
					 /*[name] => tianwnejun
					    [email] =>
					    [pwd] =>
					    [user_headimg] => http://tvax2.sinaimg.cn/crop.227.99.568.568.1024/006XZlhTly8fkfpvu5yd9j30sg0lcans.jpg
					    [open_id] => 6383220657
					    [open_nickname] => tianwnejun*/
					    $email=$_POST['email'];
					    $name=$_POST['name'];
					    $pwd=$_POST['pwd'];

					    $model=new Admin();
					    $model->name=$name;
					     $model->pwd=$pwd;
					      $model->email=$email;
					      $model->headingimg=isset($_POST['user_headimg'])?$_POST['user_headimg']:null;
					      $model->save();



					      //新建一个session_id用来生成唯一的激活码
					       $session=Yii::$app->session;
							$session['statuscode']='thisisacode';
							$statuscode=session_id('statuscode');





					     //绑定
					      $open = new OpenInfo();
								$open->open_id = $_POST['open_id'];
								$open->user_id = $model->id;//这个admin标的model新增的ID
								$open->nickname = $_POST['open_nickname'];
								$open->type = 1; // type=1为微博
								$open->create_time = time();
								$open->statuscode=base64_encode($statuscode);
								if($open->validate())
								{
								    $open->save();
								    //openinfo标的新增用户ID
								    $oid=$open->id;
								    $statuscode=$open->statuscode;

							 //openinfo表保存成功的话就发邮件让用户去激活
						/*注册邮箱激活流程

						1、用户注册
						2、插入用户数据，此时帐号未激活状态。
						3、将用户名密码或其他标识字符加密构造成激活识别码（你也可以叫激活码）。
						4、将构造好的激活识别码组成URL发送到用户提交的邮箱。
						5、用户登录邮箱并点击URL，进行激活。
						6、验证激活识别码，如果正确则激活帐号。*/
						//$urlpath="http://www.ayii.com/backend/web/index.php?r=login/bang&code='$statuscode'";

									//获取授权码并且调用发送激活链接邮件方法

							$body="<a href='http://www.ayii.com/backend/web/index.php?r=login/bang&code=".$statuscode."&oid=".$oid."'>"
									."http://www.ayii.com/backend/web/index.php?r=login/bang"
									."</a>"
									."<br/>请牢记您的账号：$name"
									."<br/>密码：$pwd";




								$subject="这里是无线点餐平台请点击激活";

								$res=Yii::$app->mailer->compose()
							->setTo($email)//对方邮箱
							->setSubject($subject)//标题
							->setHtmlBody($body)
							->send();
					if($res){
						echo "<script>alert('邮件发送成功等待激活');location.href='http://www.ayii.com/backend/web/index.php?r=login/deng'</script>";
					}else{
						echo "<script>alert('对不起请确认您输入的是有效的email');window.history.go(-1)</script>";
					}



				}



	}


}



public function actionDeng()
{
echo "等待激活中请不要关闭浏览器您需要在1000秒之内前往邮箱激活。。。。。。。。";
}



			public function actionAddress()
			{

				$data=regionCopy::find()->where('parent_id=1')->asArray()->all();
				return $this->render('address',['data'=>$data]);

			}

			public function actionGetson()
			{
				$id=Yii::$app->request->post('id');
				$res= regionCopy::find()->where("parent_id=:id",[':id'=>$id])->asArray()->all();
				echo  json_encode($res);

			}

}
 ?>


 ?>