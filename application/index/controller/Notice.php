<?php

namespace app\index\controller;

use think\Controller;
use think\Db;

class Notice extends Controller
{
    public function index()
    {
        $notices = Db::name('cms_notice')->where(['status'=>1])->where('start_time','<',time())->where('end_time','>',time())->select();
//        halt($notices);
        return view('index',compact('notices'));
    }

    public function detail($id =null)
    {

        if (empty($this->request->param('id'))){
            $this->error('参数有错',url('index/notice/index'));
        }
        $notice = Db::name('cms_notice')->find($id);
//        halt($notice);
        if ($notice){
            Db::name('cms_notice')->where(['id'=>$id])->setInc('view');
            return view('detail',compact('notice'));
        }else{
            $this->error('该参数的数据没有找到',url('index/notice/index'));
        }

    }
}
