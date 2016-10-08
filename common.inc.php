<?php
/**
 * Created by PhpStorm.
 * User: ljl
 * Date: 2016/6/15
 * Time: 13:53
 */
//防止恶意调用
if(!defined('IN_TG')){
    exit('Access Defined！');
}
//设置字符集编码
header('Content-Type:text/html;charset=utf-8');
//装换成绝对路径
 define('ROOT_PATH',dirname(__FILE__));
//echo ROOT_PATH;
//创建一个自动转义状态的常量
define('GPC',get_magic_quotes_gpc());
//拒绝PHP低版本
if (PHP_VERSION < '4.1.0') {
    exit('Version is to Low!');
}
//引用核心函数库
require ROOT_PATH.'/includes/global.func.php';
require ROOT_PATH.'/includes/mysql.func.php';
//执行耗时
define('START_TIME',_runtime());
date_default_timezone_set("Asia/Shanghai");
////数据库连接
//define('DB_HOST','159.226.15.68');
//define('DB_USER','root');
//define('DB_PWD','lijinglong');
//define("DB_NAME",'selfdatabase');
define('DB_HOST','localhost');
define('DB_USER','ljl');
define('DB_PWD','ljlself5881');
define('DB_NAME','self');
//初始化数据库
$_connect = new mysqli();
$_connect = @mysqli_connect(DB_HOST,DB_USER,DB_PWD);

_select_db($_connect,DB_NAME);
_set_names($_connect);








