<?php


/**
 * Created by PhpStorm.
 * User: mtt17
 * Date: 2018/4/9
 * Time: 11:32
 */

namespace App\Components;


use App\Components\Common\Utils;
use App\Models\UserAddr;

//V2版本的manager层，主要优化了getInfoByLevel，其中level需要传入1,3,5这样的形式，更加灵活和合理
class UserAddrManager
{

    /*
     * getById
     *
    * By Auto CodeCreator
    *
    * 2020-02-02 04:07:17
     */
    public static function getById($id)
    {
        $info = UserAddr::where('id', $id)->first();
        return $info;
    }

    /*
    * getByIdWithTrashed
    *
    * By Auto CodeCreator
    *
    * 2020-02-02 04:07:17
    */
    public static function getByIdWithTrashed($id)
    {
        $info = UserAddr::withTrashed()->where('id', $id)->first();
        return $info;
    }

    /*
    * deleteById
    *
    * By Auto CodeCreator
    *
    * 2020-02-02 04:07:17
    */
    public static function deleteById($id)
    {
        $info = self::getById($id);
        $result = $info->delete();
        return $result;
    }


    /*
    * save
    *
    * By Auto CodeCreator
    *
    * 2020-02-02 04:07:17
    */
    public static function save($info)
    {
        $result = $info->save();
        return $result;
    }


    /*
     * getInfoByLevel
     *
    * By Auto CodeCreator
    *
    * 2020-02-02 04:07:17
     *
     */
    public static function getInfoByLevel($info, $level)
    {
        $level_arr = explode(',', $level);

        $info->status_str = Utils::COMMON_STATUS_VAL[$info->status];

        //图片转数组，2020-01-19 TerryQi补充了img转数组，img一般定义为图片链接，多张图片用逗号分隔
        if ($info->img) {
            $info->img_arr = explode(",", $info->img);
        }

        //0:
        if (in_array('0', $level_arr)) {

        }
        //1:
        if (in_array('1', $level_arr)) {

        }
        //2:
        if (in_array('2', $level_arr)) {

        }

        //X:        脱敏
        if (strpos($level, 'X') !== false) {

        }
        //Y:        压缩，去掉content_html等大报文信息
        if (strpos($level, 'Y') !== false) {
            unset($info->content_html);
            unset($info->seq);
            unset($info->status);
            unset($info->updated_at);
            unset($info->deleted_at);
        }
        //Z:        预留
        if (strpos($level, 'Z') !== false) {

        }


        return $info;
    }

    /*
     * getListByCon
     *
    * By Auto CodeCreator
    *
    * 2020-02-02 04:07:17
     */
    public static function getListByCon($con_arr, $is_paginate)
    {
        $infos = new UserAddr();

        if (array_key_exists('search_word', $con_arr) && !Utils::isObjNull($con_arr['search_word'])) {
            $keyword = $con_arr['search_word'];
            $infos = $infos->where(function ($query) use ($keyword) {
                $query->where('name', 'like', "%{$keyword}%");
            });
        }

        if (array_key_exists('ids_arr', $con_arr) && !empty($con_arr['ids_arr'])) {
            $infos = $infos->wherein('id', $con_arr['ids_arr']);
        }

    
        if (array_key_exists('id', $con_arr) && !Utils::isObjNull($con_arr['id'])) {
            $infos = $infos->where('id', '=', $con_arr['id']);
        }
    
        if (array_key_exists('user_id', $con_arr) && !Utils::isObjNull($con_arr['user_id'])) {
            $infos = $infos->where('user_id', '=', $con_arr['user_id']);
        }
    
        if (array_key_exists('name', $con_arr) && !Utils::isObjNull($con_arr['name'])) {
            $infos = $infos->where('name', '=', $con_arr['name']);
        }
    
        if (array_key_exists('province', $con_arr) && !Utils::isObjNull($con_arr['province'])) {
            $infos = $infos->where('province', '=', $con_arr['province']);
        }
    
        if (array_key_exists('city', $con_arr) && !Utils::isObjNull($con_arr['city'])) {
            $infos = $infos->where('city', '=', $con_arr['city']);
        }
    
        if (array_key_exists('street', $con_arr) && !Utils::isObjNull($con_arr['street'])) {
            $infos = $infos->where('street', '=', $con_arr['street']);
        }
    
        if (array_key_exists('address', $con_arr) && !Utils::isObjNull($con_arr['address'])) {
            $infos = $infos->where('address', '=', $con_arr['address']);
        }
    
        if (array_key_exists('zip_code', $con_arr) && !Utils::isObjNull($con_arr['zip_code'])) {
            $infos = $infos->where('zip_code', '=', $con_arr['zip_code']);
        }
    
        if (array_key_exists('phonenum', $con_arr) && !Utils::isObjNull($con_arr['phonenum'])) {
            $infos = $infos->where('phonenum', '=', $con_arr['phonenum']);
        }
    
        if (array_key_exists('is_default', $con_arr) && !Utils::isObjNull($con_arr['is_default'])) {
            $infos = $infos->where('is_default', '=', $con_arr['is_default']);
        }
    
        if (array_key_exists('seq', $con_arr) && !Utils::isObjNull($con_arr['seq'])) {
            $infos = $infos->where('seq', '=', $con_arr['seq']);
        }
    
        if (array_key_exists('status', $con_arr) && !Utils::isObjNull($con_arr['status'])) {
            $infos = $infos->where('status', '=', $con_arr['status']);
        }
    
        if (array_key_exists('created_at', $con_arr) && !Utils::isObjNull($con_arr['created_at'])) {
            $infos = $infos->where('created_at', '=', $con_arr['created_at']);
        }
    
        if (array_key_exists('updated_at', $con_arr) && !Utils::isObjNull($con_arr['updated_at'])) {
            $infos = $infos->where('updated_at', '=', $con_arr['updated_at']);
        }
    
        if (array_key_exists('deleted_at', $con_arr) && !Utils::isObjNull($con_arr['deleted_at'])) {
            $infos = $infos->where('deleted_at', '=', $con_arr['deleted_at']);
        }
    
        //排序设定
        if (array_key_exists('orderby', $con_arr) && is_array($con_arr['orderby'])) {
            $orderby_arr = $con_arr['orderby'];
            //例子，传入数据样式为'status'=>'desc'
            if (array_key_exists('status', $orderby_arr) && !Utils::isObjNull($orderby_arr['status'])) {
                $infos = $infos->orderby('status', $orderby_arr['status']);
            }
            //如果传入random，代表要随机获取
            if (array_key_exists('random', $orderby_arr) && !Utils::isObjNull($orderby_arr['random'])) {
                $infos = $infos->inRandomOrder();
            }
        }
        $infos = $infos->orderby('seq', 'desc')->orderby('id', 'desc');

        //分页设定
        if ($is_paginate) {
            $page_size = Utils::PAGE_SIZE;
            //如果con_arr中有page_size信息
            if (array_key_exists('page_size', $con_arr) && !Utils::isObjNull($con_arr['page_size'])) {
                $page_size = $con_arr['page_size'];
            }
            $infos = $infos->paginate($page_size);
        }
        else {
            //如果con_arr中有page_size信息 2019-10-08优化，可以不分页也获取多条数据
            if (array_key_exists('page_size', $con_arr) && !Utils::isObjNull($con_arr['page_size'])) {
                $page_size = $con_arr['page_size'];
                $infos = $infos->take($page_size);
            }
            $infos = $infos->get();
        }
        return $infos;
    }

    /*
     * setInfo
     *
    * By Auto CodeCreator
    *
    * 2020-02-02 04:07:17
     */
    public static function setInfo($info, $data)
    {

        
        if (array_key_exists('id', $data)) {
                $info->id = $data['id'];
            }
        
        if (array_key_exists('user_id', $data)) {
                $info->user_id = $data['user_id'];
            }
        
        if (array_key_exists('name', $data)) {
                $info->name = $data['name'];
            }
        
        if (array_key_exists('province', $data)) {
                $info->province = $data['province'];
            }
        
        if (array_key_exists('city', $data)) {
                $info->city = $data['city'];
            }
        
        if (array_key_exists('street', $data)) {
                $info->street = $data['street'];
            }
        
        if (array_key_exists('address', $data)) {
                $info->address = $data['address'];
            }
        
        if (array_key_exists('zip_code', $data)) {
                $info->zip_code = $data['zip_code'];
            }
        
        if (array_key_exists('phonenum', $data)) {
                $info->phonenum = $data['phonenum'];
            }
        
        if (array_key_exists('is_default', $data)) {
                $info->is_default = $data['is_default'];
            }
        
        if (array_key_exists('seq', $data)) {
                $info->seq = $data['seq'];
            }
        
        if (array_key_exists('status', $data)) {
                $info->status = $data['status'];
            }
        
        if (array_key_exists('created_at', $data)) {
                $info->created_at = $data['created_at'];
            }
        
        if (array_key_exists('updated_at', $data)) {
                $info->updated_at = $data['updated_at'];
            }
        
        if (array_key_exists('deleted_at', $data)) {
                $info->deleted_at = $data['deleted_at'];
            }
        
        return $info;
    }

    /*
    * 统一封装数量操作，部分对象涉及数量操作，例如产品销售，剩余数等，统一通过该方法封装
    *
    * By Auto CodeCreator
    *
    * 2020-02-02 04:07:17
    *
    * @param  id：对象id item：操作对象 num：加减数值
    */
    public static function setNum($id, $item, $num)
    {
        $info = self::getById($id);
        switch ($item) {
            case "show_num":
                $info->show_num = $info->show_num + $num;
            break;
            case "left_num":
                $info->left_num = $info->left_num + $num;
                break;
            case "send_num":
                $info->send_num = $info->send_num + $num;
                break;
        }
        $info->save();
        return $info;
    }

    /*
    * 获取最近的一条信息
    *
    * By TerryQi
    *
    */
    public static function getLatest()
    {
        $info = self::getListByCon(['status' => '1'], false)->first();
        return $info;
    }

}

