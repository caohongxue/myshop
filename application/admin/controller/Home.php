<?php

namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Request;
use think\Session;

class Home extends Base
{
    /**
     * 显示首页资源统计列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $order_count=Db::table('order_info')->where('is_del',0)->count();

        return $this->fetch('index');
    }

}
