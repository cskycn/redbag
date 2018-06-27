<?php
namespace Common\Model;

use Common\Controller\FunMethod;
use Think\Model;

/**
 * 基础model
 */
class BaseModel extends Model
{
    //默认表名配置
    protected $_config = array(
        'ADMIN' => 'admin',
        'ADMIN_LOG' => 'admin_log',
        'COMMENT' => 'comment',
        'FORUM_POST' => 'forum_post',
        'MEMBERS' => 'members'
    );

    public function _initialize()
    {
        $prefix = C('DB_PREFIX');
        $this->_config['ADMIN'] = $prefix . $this->_config['ADMIN'];
        $this->_config['ADMIN_LOG'] = $prefix . $this->_config['ADMIN_LOG'];
        $this->_config['COMMENT'] = $prefix . $this->_config['COMMENT'];
        $this->_config['FORUM_POST'] = $prefix . $this->_config['FORUM_POST'];
        $this->_config['MEMBERS'] = $prefix . $this->_config['MEMBERS'];
    }

    /**
     * 添加数据
     * @param  array $data 添加的数据
     * @return int          新增的数据id
     */
    public function addData($data)
    {
        // 对data数据进行验证
        if (!$data = $this->create($data)) {
            // 验证不通过返回错误
            return false;
        } else {
            // 验证通过
            // 去除键值首尾的空格
            foreach ($data as $k => $v) {
                $data[$k] = trim($v);
            }
            $id = $this->add($data);
            return $id;
        }
    }

    /**
     * 修改数据
     * @param   array $map where语句数组形式
     * @param   array $data 数据
     * @return  boolean         操作是否成功
     */
    public function editData($map, $data)
    {
        // 对data数据进行验证
        if (!$data = $this->create($data)) {
            // 验证不通过返回错误
            return false;
        } else {
            // 验证通过
            // 去除键值首位空格
            foreach ($data as $k => $v) {
                $data[$k] = trim($v);
            }
            $result = $this->where($map)->save($data);
            return $result;
        }
    }

    /**
     * 删除数据
     * @param   array $map where语句数组形式
     * @return  boolean         操作是否成功
     */
    public function deleteData($map, $flag = false)
    {
        if (empty($map)) {
            die('where为空的危险操作');
        }
        if (!$flag) {
            $result = $this->where($map)->save(array('is_deleted' => 1));
        } else {
            $result = $this->where($map)->delete();
        }

        return $result;
    }

    /**
     * 数据排序
     * @param  array $data 数据源
     * @param  string $id 主键
     * @param  string $order 排序字段
     * @return boolean       操作是否成功
     */
    public function orderData($data, $id = 'id', $order = 'order_number')
    {
        foreach ($data as $k => $v) {
            $v = empty($v) ? null : $v;
            $this->where(array($id => $k))->save(array($order => $v));
        }
        return true;
    }

    /**
     * 获取全部数据
     * @param  string $type tree获取树形结构 level获取层级结构
     * @param  string $order 排序方式
     * @return array         结构数据
     */
    public function getTreeData($type = 'tree', $order = '', $name = 'name', $child = 'id', $parent = 'pid')
    {
        // 判断是否需要排序
        if (empty($order)) {
            $data = $this->where("is_deleted=0")->select();
        } else {
            $data = $this->where("is_deleted=0")->order($order . ' is null,' . $order)->select();
        }
        // 获取树形或者结构数据
        if ($type == 'tree') {
            $data = \Org\Nx\Data::tree($data, $name, $child, $parent);
        } elseif ($type = "level") {
            $data = \Org\Nx\Data::channelLevel($data, 0, '&nbsp;', $child);
        }
        return $data;
    }

    /**
     * 获取分页数据
     * @param  subject $model model对象
     * @param  array $map where条件
     * @param  string $order 排序规则
     * @param  integer $limit 每页数量
     * @param  integer $field $field
     * @return array            分页数据
     */
    public function getPage($model, $map, $order = '', $limit = 10, $field = '')
    {
        $map['is_deleted'] = 0;
        $count = $model
            ->where($map)
            ->count();
        $page = FunMethod::new_page($count, $limit);
        // 获取分页数据
        if (empty($field)) {
            $list = $model
                ->where($map)
                ->order($order)
                ->limit($page->firstRow . ',' . $page->listRows)
                ->select();
        } else {
            $list = $model
                ->field($field)
                ->where($map)
                ->order($order)
                ->limit($page->firstRow . ',' . $page->listRows)
                ->select();
        }
        $data = array(
            'data' => $list,
            'page' => $page->show(),
            'nowPage'=>$page->getNowPage()
        );
        return $data;
    }
}
