<?php
/**
 * Created by PhpStorm.
 * User: ljl
 * Date: 2016/6/20
 * Time: 17:10
 */
session_start();
//防止恶意调用
define('IN_TG',true);
require 'common.inc.php';
//退出
_unsetcookies();

