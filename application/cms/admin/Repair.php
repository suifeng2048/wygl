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

namespace app\cms\admin;

use app\admin\controller\Admin;
use app\common\builder\ZBuilder;
use app\cms\model\Repair as RepairModel;
//use app\cms\model\AdvertType as AdvertTypeModel;
use think\Db;
use think\Validate;

/**
 * 广告控制器
 * @package app\cms\admin
 */
class Repair extends Admin
{
    /**
     * 广告列表
     * @author 蔡伟明 <314013107@qq.com>
     * @return mixed
     */
    public function index()
    {
        // 查询
        $map = $this->getMap();
        // 排序
        $order = $this->getOrder('update_time desc');
        // 数据列表
        $data_list = RepairModel::where($map)->order($order)->paginate();


        // 使用ZBuilder快速创建数据表格
        return ZBuilder::make('table')
            ->setSearch(['title' => '标题']) // 设置搜索框
            ->addColumns([ // 批量添加数据列
                ['id', 'ID', 'text'],
                ['no', '报修编号', 'text'],
                ['name', '保修人', 'text.edit'],
                ['tel', '报修电话', 'text'],
                ['address', '报修地址', 'text'],
                ['create_time', '报修时间', 'datetime'],
                ['update_time', '状态时间', 'datetime'],
                ['status', '状态', 'text'],
                ['right_button', '操作', 'btn']
            ])
            ->addTopButtons('add,enable,disable,delete') // 批量添加顶部按钮
            ->addRightButtons(['edit', 'delete' => ['data-tips' => '删除后无法恢复。']]) // 批量添加右侧按钮
            ->setRowList($data_list) // 设置表格数据
            ->addOrder('id,no,name,tel,address,create_time,update_time')
            ->setPrimaryKey('id') // 设置主键名为username
            ->fetch(); // 渲染模板
    }

    /**
     * 新增
     * @author 蔡伟明 <314013107@qq.com>
     * @return mixed
     */
    public function add()
    {
        // 保存数据
        if ($this->request->isPost()) {
            // 表单数据
            $data = $this->request->post();

            // 验证
            $result = $this->validate($data, 'Repair');
            if (true !== $result) $this->error($result);
            if ($advert = RepairModel::create($data)) {
                // 记录行为
//                action_log('advert_add', 'cms_advert', $advert['id'], UID, $data['name']);
                $this->success('新增成功', 'index');
            } else {
                $this->error('新增失败');
            }
        }
        $no = uniqid('wygl_').date('His',time());
//        var_dump($no);exit;
        // 显示添加页面
        return ZBuilder::make('form')
            ->setPageTips('如果出现无法添加的情况，可能由于浏览器将本页面当成了广告，请尝试关闭浏览器的广告过滤功能再试。', 'warning')
            ->addFormItems([
                ['text', 'no', '报修编号','<code>该项请勿更改</code>'],
                ['text', 'name', '报修人'],
                ['text', 'tel', '电话','<code>必填数字</code>'],
                ['text', 'content', '报修内容'],
                ['text', 'address', '地址', '<code>必填</code>'],
                ['radio', 'status', '状态', '', ['否', '是'], 1]
            ])
            ->setFormData(['no' => $no])
            ->fetch();
    }

    /**
     * 编辑
     * @param null $id 广告id
     * @author 蔡伟明 <314013107@qq.com>
     * @return mixed
     */
    public function edit($id = null)
    {
        if ($id === null) $this->error('缺少参数');

        // 保存数据
        if ($this->request->isPost()) {
            // 表单数据
            $data = $this->request->post();

            // 验证
            $result = $this->validate($data, 'Notice');
            if (true !== $result) $this->error($result);

            if (NoticeModel::update($data)) {
                // 记录行为
//                action_log('advert_edit', 'cms_advert', $id, UID, $data['name']);
                $this->success('编辑成功', 'index');
            } else {
                $this->error('编辑失败');
            }
        }

        $info = NoticeModel::get($id);
//        $info['ad_type'] = ['代码', '文字', '图片', 'flash'][$info['ad_type']];

        // 显示编辑页面
        return ZBuilder::make('form')
            ->setPageTips('如果出现无法添加的情况，可能由于浏览器将本页面当成了广告，请尝试关闭浏览器的广告过滤功能再试。', 'warning')
            ->addFormItems([
                ['hidden', 'id'],
                ['text', 'title', '通知名称'],
                ['text', 'author', '发布人'],
                ['text', 'view', '浏览量','<code>必填数字</code>'],
                ['daterange', 'start_time,end_time', '开始时间-结束时间'],

                ['ckeditor', 'content','通知内容'],
                ['image', 'logo', '图片', '<code>必须</code>'],

                ['radio', 'status', '状态', '', ['否', '是']]
            ])
//            ->setTrigger('timeset', '1', 'start_time')
            ->setFormData($info)
            ->fetch();
    }

    /**
     * 删除广告
     * @param array $record 行为日志
     * @author 蔡伟明 <314013107@qq.com>
     * @return mixed
     */
    public function delete($record = [])
    {
        return $this->setStatus('delete');
    }

    /**
     * 启用广告
     * @param array $record 行为日志
     * @author 蔡伟明 <314013107@qq.com>
     * @return mixed
     */
    public function enable($record = [])
    {
//        return $this->setStatus('enable');
        if ($this->request->param('id')) {
            $id = $this->request->param('id');
        }else{
            $this->error('参数有错');
        }
        $repair = Db::name('cms_repair')->where(['id'=>$id])->setInc('status');
//        halt($repair);exit;
        if ($repair){
            $this->success('修改状态成功',url('repair/index'));
        }else{
           $this->error('修改状态失败');
        }
    }

    /**
     * 禁用广告
     * @param array $record 行为日志
     * @author 蔡伟明 <314013107@qq.com>
     * @return mixed
     */
    public function disable($record = [])
    {
        return $this->setStatus('disable');
    }

    /**
     * 设置广告状态：删除、禁用、启用
     * @param string $type 类型：delete/enable/disable
     * @param array $record
     * @author 蔡伟明 <314013107@qq.com>
     * @return mixed
     */
    public function setStatus($type = '', $record = [])
    {
        $ids         = $this->request->isPost() ? input('post.ids/a') : input('param.ids');
        $notice_name = NoticeModel::where('id', 'in', $ids)->column('title');
        return parent::setStatus($type, ['notice_'.$type, 'cms_notice', 0, UID, implode('、', $notice_name)]);
    }

    /**
     * 快速编辑
     * @param array $record 行为日志
     * @author 蔡伟明 <314013107@qq.com>
     * @return mixed
     */
    public function quickEdit($record = [])
    {
        $id      = input('post.pk', '');
        $field   = input('post.name', '');
        $value   = input('post.value', '');
        $notice  = NoticeModel::where('id', $id)->value($field);
        $details = '字段(' . $field . ')，原值(' . $notice . ')，新值：(' . $value . ')';
        return parent::quickEdit(['notice_edit', 'cms_notice', $id, UID, $details]);
    }
}