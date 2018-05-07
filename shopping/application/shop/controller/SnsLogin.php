<?php

namespace app\shop\controller;

use anerg\OAuth2\OAuth;

class SnsLogin {

    /**
     * 此处应当考虑使用空控制器来简化代码
     * 同时应当考虑对第三方渠道名称进行检查
     * $config配置参数应当放在配置文件中
     * callback对应了普通PC版的返回页面和移动版的页面
     */
    public function qq() {
        $config = [
            'app_key'    => '101353491',
            'app_secret' => 'df4e46ba7da52f787c6e3336d30526e4',
            'scope'      => 'get_user_info',
            'callback'   => [
                'default' => 'http://iwebshop.com/sns_login/callback/qq',
                //'mobile'  => 'http://h5.xxx.com/sns_login/callback/qq',
            ]
        ];
        $OAuth  = OAuth::getInstance($config, 'qq');
        
       // $OAuth->setDisplay('mobile'); //此处为可选,若没有设置为mobile,则跳转的授权页面可能不适合手机浏览器访问
        return redirect($OAuth->getAuthorizeURL());
    }

    public function callback($channel) {
        $config   = [
            'app_key'    => 'xxxxxx',
            'app_secret' => 'xxxxxxxxxxxxxxxxxxxx',
            'scope'      => 'get_user_info',
            'callback'   => [
                'default' => 'http://xxx.com/sns_login/callback/qq',
                'mobile'  => 'http://h5.xxx.com/sns_login/callback/qq',
            ]
        ];
        $OAuth    = OAuth::getInstance($config, $channel);
        $OAuth->getAccessToken();
        /**
         * 在获取access_token的时候可以考虑忽略你传递的state参数
         * 此参数使用cookie保存并验证
         */
//        $ignore_stat = true;
//        $OAuth->getAccessToken(true);
        $sns_info = $OAuth->userinfo();
        /**
         * 此处获取了sns提供的用户数据
         * 你可以进行其他操作
         */
    }

}