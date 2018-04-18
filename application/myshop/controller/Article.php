<?php

namespace app\myshop\controller;

use think\Controller;
use think\Db;
use think\Request;

class Article extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $iphone=Db::table('goods')
            ->where(['cat_id'=>1,'is_show'=>1])
            ->limit(8)
            ->select();
        $brand=Db::table('brand')
            ->where(['is_show'=>1])
            ->limit(6)
            ->select();
        return $this->fetch('index',['iphone'=>$iphone,'brand'=>$brand]);
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function each($id){
        $data=Db::name('goods')->find($id);
//        var_dump($data);die;
        $brand=Db::name('brand')->find($data['brand_id']);
        $run=Db::name('processor')->find($data['runme_id']);
        $pro=Db::name('processor')->find($data['pro_id']);
        $mem=Db::name('running_memory')->find($data['memory_id']);
        return $this->fetch('each',['data'=>$data,'brand'=>$brand,'pro'=>$pro,'run'=>$run,'mem'=>$mem]);
    }




    public function create()
    {
        //
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }
}