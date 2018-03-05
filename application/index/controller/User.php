<?php

namespace app\index\controller;
use think\Db;

class User extends Base
{
    public function index()
    {
        $userinfo = session('wechat_user');
        $user = Db::name('user')->where(['open_id'=>$userinfo['id']])->find();
//        halt($user);exit;
        //如果不存在$user 用户 执行添加操作
        if ($user===null && $userinfo){
            Db::name('user')->insert([
                'open_id'=>$userinfo['id'],
                'logo'=>$userinfo['avatar'],
                'name'=>$userinfo['name'],
                'address'=>$userinfo['original']['country'].$userinfo['original']['province'].$userinfo['original']['city']
            ]);
            $user = Db::name('user')->where(['open_id'=>$userinfo['id']])->find();
        }
        return view('index',compact('user'));
    }
}
