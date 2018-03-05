<?php

namespace app\index\controller;

use think\Controller;
use EasyWeChat\Foundation\Application;

class Wechat extends Controller
{
    public function callback()
    {
        $config = config('wx');

        $app = new Application($config);
        $oauth = $app->oauth;

        // 获取 OAuth 授权结果用户信息
        $user = $oauth->user();
        session('wechat_user',$user->toArray());
//        $_SESSION['wechat_user'] = $user->toArray();

        $targetUrl = empty(session('target_url')) ? '/' : session('target_url');

        //header('location:'. $targetUrl);
        // 跳转到 user/profile
        return $this->redirect($targetUrl);
    }

    public function index()
    {

        $options = config('wx');

        $app = new Application($options);

        $server = $app->server;

        $server->setMessageHandler(function($message){
            // 注意，这里的 $message 不仅仅是用户发来的消息，也可能是事件
            // 当 $message->MsgType 为 event 时为事件
            if ($message->MsgType == 'event') {
                # code...
                switch ($message->Event) {
                    case 'subscribe':
                        # code...
                        break;

                    default:
                        # code...
                        break;
                }
            }
        });

        $response = $server->serve();

        $response->send(); // Laravel 里请使用：return $response;
    }
}
