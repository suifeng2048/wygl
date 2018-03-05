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
class Notice extends Validate
{
    // 定义验证规则
    protected $rule = [
        'title'  =>  'require|max:25',
        'author'  =>  'require|max:25',
        'start_time'    => 'require',
        'end_time'      => 'require',
        'content'         => 'require',
        'view'          => 'integer',
        'logo'         => 'require',
    ];

    // 定义验证提示
    protected $message = [
        'title.require' => '通知名称必须',
        'title.max:25' => '通知名称长度不能超过25',
        'author.require' => '发布人必须',
        'author.max:25' => '发布人长度不能超过25',
        'content.require'          => '内容必须',
        'logo'           => '请上传图片',
    ];

    // 定义验证场景
    protected $scene = [
        'name' => ['name']
    ];
}
