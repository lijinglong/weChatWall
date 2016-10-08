<?php
/**
 * Created by PhpStorm.
 * User: ljl
 * Date: 2016/6/16
 * Time: 9:32
 */
session_start();
//防止恶意调用
define('IN_TG',true);
//引用公共文件
require 'common.inc.php';
//运行验证码函数
//默认验证码长度为：75*25，默认位数为4位，如果位数为6位，推荐长度125.
//第四个参数W控制验证码否有边框，true为有边框。
//可以通过数据库的方式，来设置验证码的属性
_code(75,25,4,false);
