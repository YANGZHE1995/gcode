<?php
/**
 * Created by PhpStorm.
 * User: TerryQi
 * Date: 2019/10/23
 * Time: 12:17
 */

namespace App\MongoDB\Models\Doc;


class VertifyDoc
{
    private $collection_name = "vertify";       //mongodb的collection名称

    private $phonenum;          //手机号
    private $code;       //验证码
    private $seq = 99;       //排序       值越大越靠前
    private $status = '1';        //状态        0：失效 1：生效

}