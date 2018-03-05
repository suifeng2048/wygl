<?php

namespace app\index\controller;

use EasyWeChat\Foundation\Application;
use think\Controller;
//use EasyWeChat\Foundation\Application;

class Base extends Controller
{
    public function _initialize()
    {
        $config = config('wx');
//        halt($config);
        $app = new Application($config);
        $oauth = $app->oauth;
        // 未登录
        if (empty(session('wechat_user'))) {

            session('target_url',strtolower($this->request->module().'/'.$this->request->controller().'/'.$this->request->action()));
//             $_SESSION['target_url'] = 'user/profile';
            //return $oauth->redirect();
            // 这里不一定是return，如果你的框架action不是返回内容的话你就得使用
             $oauth->redirect()->send();
             exit;
        }

        // 已经登录过
//        $user = $_SESSION['wechat_user'];

        // ...
        parent::_initialize();
    }
}
