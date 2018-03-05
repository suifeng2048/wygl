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

namespace app\cms\validate;

use think\Validate;

/**
 * 广告验证器
 * @package app\cms\validate
 * @author 蔡伟明 <314013107@qq.com>
 */
class Repair extends Validate
{
    // 定义验证规则
    protected $rule = [
        'name'  =>  'require|max:5',
        'tel'  =>  'require|number',
        'content'    => 'require',
        'address'      => 'require',
    ];

    // 定义验证提示
    protected $message = [
        'name.require' => '保修人必须',
        'name.max:5' => '保修人姓名长度不能超过5',
        'tel.require' => '电话必须',
        'tel.number' => '电话必须为数字',
        'content.require'          => '内容必须',
        'address'           => '地址必须',
    ];

    // 定义验证场景
    protected $scene = [
        'name' => ['name']
    ];
}
