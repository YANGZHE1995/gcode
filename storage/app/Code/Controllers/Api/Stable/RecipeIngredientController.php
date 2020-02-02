<?php

/**
* Created by PhpStorm.
* User:robot
* Date: 2020-02-02 04:07:16
* Time: 13:29
*/

namespace App\Http\Controllers\Api;


use App\Components\Common\RequestValidator;
use App\Components\RecipeIngredientManager;
use App\Components\Common\QNManager;
use App\Components\Common\Utils;
use App\Components\Common\ApiResponse;
use Illuminate\Http\Request;

class RecipeIngredientController
{

    /*
    * 根据id获取信息
    *
    * By Auto CodeCreator
    *
    * 2020-02-02 04:07:16
    */
    public function getById(Request $request)
    {
        $data = $request->all();
        $requestValidationResult = RequestValidator::validator($request->all(), [
            'id' => 'required',
        ]);
        if ($requestValidationResult !== true) {
            return ApiResponse::makeResponse(false, $requestValidationResult, ApiResponse::MISSING_PARAM);
        }
        $recipe_ingredient = RecipeIngredientManager::getById($data['id']);
        //补充信息
        if($recipe_ingredient){
            $level = null;
            if (array_key_exists('level', $data) && !Utils::isObjNull($data['level'])) {
                $level = $data['level'];
            }
            $recipe_ingredient = RecipeIngredientManager::getInfoByLevel($recipe_ingredient,$level);
        }
        return ApiResponse::makeResponse(true, $recipe_ingredient, ApiResponse::SUCCESS_CODE);
    }


    /*
    * 根据条件获取列表
    *
    * By Auto CodeCreator
    *
    * 2020-02-02 04:07:16
    */
    public function getListByCon(Request $request)
    {
        $data = $request->all();
        //自定义参数位置
        $status = '1';

        //分页和信息级别
        $is_paginate = true;
        $level='Y';

        //参数配置
        if (array_key_exists('status', $data) && !Utils::isObjNull($data['status'])) {
            $status = $data['status'];
        }
        //配置获取信息级别
        if (array_key_exists('level', $data) && !Utils::isObjNull($data['level'])) {
            $level = $data['level'];
        }
        //配置是否分页
        if (array_key_exists('is_paginate', $data) && !Utils::isObjNull($data['is_paginate'])) {
            $is_paginate = $data['is_paginate'];
        }

        //配置条件
        if (array_key_exists('status', $data) && !Utils::isObjNull($data['status'])) {
            $status = $data['status'];
        }
        $con_arr = array(
            'status' => $status,
        );
        $recipe_ingredients = RecipeIngredientManager::getListByCon($con_arr, $is_paginate);
        foreach ($recipe_ingredients as $recipe_ingredient) {
            $recipe_ingredient = RecipeIngredientManager::getInfoByLevel($recipe_ingredient, $level);
        }

        return ApiResponse::makeResponse(true, $recipe_ingredients, ApiResponse::SUCCESS_CODE);
    }
}

