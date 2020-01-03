<?php

/**
* Created by PhpStorm.
* User: mtt17
* Date: 2018/4/20
* Time: 10:50
*/

namespace App\Http\Controllers\Admin;

use App\Components\Common\RequestValidator;
use App\Components\VertifyManager;
use App\Components\Common\QNManager;
use App\Components\Common\Utils;
use App\Components\Common\ApiResponse;
use App\Models\Vertify;
use Illuminate\Http\Request;

class VertifyController
{

    /*
    * 首页
    *
    * By Auto CodeCreator
    *
    * 2020-01-03 02:14:55
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
        $vertifys =VertifyManager::getListByCon($con_arr, true);
        foreach ($vertifys as $vertify) {
        $vertify = VertifyManager::getInfoByLevel($vertify, '');
        }

        return view('admin.vertify.index', ['self_admin' => $self_admin, 'datas' => $vertifys, 'con_arr' => $con_arr]);
    }

    /*
    * 编辑-get
    *
    * By Auto CodeCreator
    *
    * 2020-01-03 02:14:55
    */
    public function edit(Request $request)
    {
        $data = $request->all();
        $self_admin = $request->session()->get('self_admin');
        //生成七牛token
        $upload_token = QNManager::uploadToken();
        $vertify = new Vertify();
        if (array_key_exists('id', $data)) {
        $vertify = VertifyManager::getById($data['id']);
        $vertify = VertifyManager::getInfoByLevel($vertify, "");
        }
        return view('admin.vertify.edit', ['self_admin' => $self_admin, 'data' => $vertify, 'upload_token' => $upload_token]);
    }


    /*
    * 添加或编辑-post
    *
    * By Auto CodeCreator
    *
    * 2020-01-03 02:14:55
    */
    public function editPost(Request $request)
    {
        $data = $request->all();
        $self_admin = $request->session()->get('self_admin');
        $vertify = new Vertify();
        //存在id是保存
        if (array_key_exists('id', $data) && !Utils::isObjNull($data['id'])) {
            $vertify = VertifyManager::getById($data['id']);
        }
        $data['admin_id'] = $self_admin['id'];
        $vertify = VertifyManager::setInfo($vertify, $data);
        VertifyManager::save($vertify);
        return ApiResponse::makeResponse(true, $vertify, ApiResponse::SUCCESS_CODE);
    }


    /*
    * 设置状态
    *
    * By Auto CodeCreator
    *
    * 2020-01-03 02:14:55
    */
    public function setStatus(Request $request, $id)
    {
        $data = $request->all();
        $vertify = VertifyManager::getById($data['id']);
        if (!$vertify) {
        return ApiResponse::makeResponse(false, "未找到删除信息", ApiResponse::INNER_ERROR);
        }
        $vertify = VertifyManager::setInfo($vertify, $data);
        VertifyManager::save($vertify);
        return ApiResponse::makeResponse(true, $vertify, ApiResponse::SUCCESS_CODE);
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
        $vertify = VertifyManager::getById($data['id']);
        if (!$vertify) {
        return ApiResponse::makeResponse(false, "未找到删除信息", ApiResponse::INNER_ERROR);
        }
        VertifyManager::deleteById($vertify->id);
        return ApiResponse::makeResponse(true, "删除成功", ApiResponse::SUCCESS_CODE);
    }


    /*
    * 查看信息
    *
    * By Auto CodeCreator
    *
    * 2020-01-03 02:14:55
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
        $vertify = VertifyManager::getById($data['id']);
        $vertify = VertifyManager::getInfoByLevel($vertify, '0');

        return view('admin.vertify.info', ['self_admin' => $self_admin, 'data' => $vertify]);
    }

}
