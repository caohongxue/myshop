<?php

namespace app\myshop\controller;

use think\Controller;
use think\Db;
use think\Request;
use think\Session;

class Collection extends Controller
{
    /**
     *加入收藏夹
     */
//    public function house($id)
//    {
//        $user_id=Session::get('user_id');
//        if(empty($user_id)){
//           $this->error('请您登陆后再收藏！',url('Login/login'));
//        }else{
//            $house_goods_di=Db::table('collection')
//                ->alias('a')
//                ->join('user w','a.user_id = w.user_id')
//                ->join('goods c','a.goods_id = c.goods_id')
//                ->where(['a.goods_id'=>$id,'a.user_id'=>$user_id,'is_attention'=>2])
//                ->select();
//        }
////        $house_goods_di=Db::table('collect_goods')
////            ->alias('a')
////            ->join('user w','a.user_id = w.user_id')
////            ->join('goods c','a.goods_id = c.goods_id')
////            ->where(['a.goods_id'=>$id,'is_attention'=>2])
////            ->select();
//////        var_dump($house_goods_di);die;
//        return $this->fetch('house',['house_goods_di'=>$house_goods_di]);
//    }

    public function house(){
//        $user_id=Session::get('user_id');
//        if(empty($user_id)){
//           $this->error('请您登陆后再收藏！',url('Login/login'));
//        }else{
//            $house_goods_di=Db::table('collect_goods')
//                ->alias('a')
//                ->join('goods w','a.goods_id = w.goods_id')
//                ->join('user c','a.user_id = c.user_id')
//                ->where(['is_attention'=>2,'user_id'=>$user_id])
//                ->select();
//        }
        $house_goods_di=Db::table('collect_goods')
            ->alias('a')
            ->join('goods w','a.goods_id = w.goods_id')
            ->join('user c','a.user_id = c.user_id')
            ->where(['is_attention'=>2])
            ->select();
        return $this->fetch('house',['house_goods_di'=>$house_goods_di]);
    }

    /**
     * 从收藏夹移除
     *
     * @return \think\Response
     */
    public function delete($id)
    {
        Db::table('collect_goods')->where(['rec_id'=>$id])->update(['is_attention'=>1]);
        $this->success('已从收藏夹移除！');
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

}
