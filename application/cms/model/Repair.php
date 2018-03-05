<?php
// +----------------------------------------------------------------------
// | 海豚PHP框架 [ DolphinPHP ]
// +----------------------------------------------------------------------
// | 版权所有 2016~2017 河源市卓锐科技有限公司 [ http://www.zrthink.com ]
// +----------------------------------------------------------------------
// | 官方网站: http://dolphinphp.com
// +----------------------------------------------------------------------
// | 开源协议 ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------

namespace app\cms\model;

use think\Model as ThinkModel;

/**
 * 广告模型
 * @package app\cms\model
 */
class Repair extends ThinkModel
{
    // 设置当前模型对应的完整数据表名称
    protected $table = '__CMS_REPAIR__';

    // 自动写入时间戳
    protected $autoWriteTimestamp = true;

    public function getStatusAttr($value)
    {

        $data = [
            '已取消',
            '待审核',
            '维修中',
            '已完成'
        ];
        $color = [
            'primary','warning','danger','success'
        ];
        $key = ($value==0 || $value == 3) ? 'disabled':'';
        return '<a class="btn btn-'.$color[$value].' '.$key.'" href="enable/id/'.$this->id.'">'.$data[$value].'</a>';
    }
    public function getStatusTextAttr($value,$data)
    {
        $route = request()->action();
        $status =  [
            '0'=>'<a href="'.$route.'/ids/'.$data['id'].'">已取消</a>',
            '1'=>'<a href="'.$route.'/ids/'.$data['id'].'">待审核</a>',
            '2'=>'<a href="'.$route.'/ids/'.$data['id'].'">维修中</a>',
            '3'=>'<a href="'.$route.'">维修完成</a>'
        ];
        return $status[$data['status']];
    }

//    // 定义修改器
    public function setStartTimeAttr($value)
    {
        return $value != '' ? strtotime($value) : 0;
    }
    public function setEndTimeAttr($value)
    {
        return $value != '' ? strtotime($value) : 0;
    }
    public function getStartTimeAttr($value)
    {
        return $value != 0 ? date('Y-m-d', $value) : '';
    }
    public function getEndTimeAttr($value)
    {
        return $value != 0 ? date('Y-m-d', $value) : '';
    }
}