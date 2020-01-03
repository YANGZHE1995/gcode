<?php

/**
* Created by PhpStorm.
* User: mtt17
* Date: 2018/4/20
* Time: 10:50
*/

namespace App\Http\Controllers\Admin;

use App\Components\Common\RequestValidator;
use App\Components\DailyCheckOrderManager;
use App\Components\Common\QNManager;
use App\Components\Common\Utils;
use App\Components\Common\ApiResponse;
use App\Models\DailyCheckOrder;
use Illuminate\Http\Request;

class DailyCheckOrderController
{

    /*
    * 首页
    *
    * By Auto CodeCreator
    *
    * 2020-01-03 02:14:40
    */
    public function index(Request $request)
    {
        $self_admin = $request->session()->get('self_admin');
        $data = $request->all();
        //相关搜素条件
        $status = null;
        $search_word = null;
        if (array_key_exists('status', $data) && !Utils::isObjNull($data['status'])) {
            $status = $data['status'];
        }
        if (array_key_exists('search_word', $data) && !Utils::isObjNull($data['search_word'])) {
            $search_word = $data['search_word'];
        }
        $con_arr = array(
            'status' => $status,
            'search_word' => $search_word,
        );
        $daily_check_orders =DailyCheckOrderManager::getListByCon($con_arr, true);
        foreach ($daily_check_orders as $daily_check_order) {
        $daily_check_order = DailyCheckOrderManager::getInfoByLevel($daily_check_order, '');
        }

        return view('admin.dailyCheckOrder.index', ['self_admin' => $self_admin, 'datas' => $daily_check_orders, 'con_arr' => $con_arr]);
    }

    /*
    * 编辑-get
    *
    * By Auto CodeCreator
    *
    * 2020-01-03 02:14:40
    */
    public function edit(Request $request)
    {
        $data = $request->all();
        $self_admin = $request->session()->get('self_admin');
        //生成七牛token
        $upload_token = QNManager::uploadToken();
        $daily_check_order = new DailyCheckOrder();
        if (array_key_exists('id', $data)) {
        $daily_check_order = DailyCheckOrderManager::getById($data['id']);
        $daily_check_order = DailyCheckOrderManager::getInfoByLevel($daily_check_order, "");
        }
        return view('admin.dailyCheckOrder.edit', ['self_admin' => $self_admin, 'data' => $daily_check_order, 'upload_token' => $upload_token]);
    }


    /*
    * 添加或编辑-post
    *
    * By Auto CodeCreator
    *
    * 2020-01-03 02:14:40
    */
    public function editPost(Request $request)
    {
        $data = $request->all();
        $self_admin = $request->session()->get('self_admin');
        $daily_check_order = new DailyCheckOrder();
        //存在id是保存
        if (array_key_exists('id', $data) && !Utils::isObjNull($data['id'])) {
            $daily_check_order = DailyCheckOrderManager::getById($data['id']);
        }
        $data['admin_id'] = $self_admin['id'];
        $daily_check_order = DailyCheckOrderManager::setInfo($daily_check_order, $data);
        DailyCheckOrderManager::save($daily_check_order);
        return ApiResponse::makeResponse(true, $daily_check_order, ApiResponse::SUCCESS_CODE);
    }


    /*
    * 设置状态
    *
    * By Auto CodeCreator
    *
    * 2020-01-03 02:14:40
    */
    public function setStatus(Request $request, $id)
    {
        $data = $request->all();
        $daily_check_order = DailyCheckOrderManager::getById($data['id']);
        if (!$daily_check_order) {
        return ApiResponse::makeResponse(false, "未找到删除信息", ApiResponse::INNER_ERROR);
        }
        $daily_check_order = DailyCheckOrderManager::setInfo($daily_check_order, $data);
        DailyCheckOrderManager::save($daily_check_order);
        return ApiResponse::makeResponse(true, $daily_check_order, ApiResponse::SUCCESS_CODE);
    }

    /*
    * 删除
    *
    * By Auto CodeCreator
    *
    * 2019-05-18 17:14:16
    */
    public function deleteById(Request $request, $id)
    {
        $data = $request->all();
        $daily_check_order = DailyCheckOrderManager::getById($data['id']);
        if (!$daily_check_order) {
        return ApiResponse::makeResponse(false, "未找到删除信息", ApiResponse::INNER_ERROR);
        }
        DailyCheckOrderManager::deleteById($daily_check_order->id);
        return ApiResponse::makeResponse(true, "删除成功", ApiResponse::SUCCESS_CODE);
    }


    /*
    * 查看信息
    *
    * By Auto CodeCreator
    *
    * 2020-01-03 02:14:40
    *
    */
    public function info(Request $request)
    {
        $data = $request->all();
        $self_admin = $request->session()->get('self_admin');
        //合规校验
        $requestValidationResult = RequestValidator::validator($request->all(), [
        'id' => 'required',
        ]);
        if ($requestValidationResult !== true) {
        return redirect()->action('\App\Http\Controllers\Admin\IndexController@error', ['msg' => '合规校验失败，请检查参数' . $requestValidationResult]);
        }
        //信息
        $daily_check_order = DailyCheckOrderManager::getById($data['id']);
        $daily_check_order = DailyCheckOrderManager::getInfoByLevel($daily_check_order, '0');

        return view('admin.dailyCheckOrder.info', ['self_admin' => $self_admin, 'data' => $daily_check_order]);
    }

}
