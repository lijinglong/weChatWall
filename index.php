<?php
/**
 * Created by PhpStorm.
 * User: ljl
 * Date: 2016/6/15
 * Time: 15:18
 */
//防止恶意调用
define('IN_TG',true);
//定义一个常量指定本页内容
define('SCRIPT','index');
//将php错误信息输出在页面
ini_set("display_errors", "On");
error_reporting(E_ALL | E_STRICT);
//引用公共文件
require 'common.inc.php';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
    <title>多用户留言系统首页</title>
      <?php
        require ROOT_PATH.'/includes/title.inc.php';
      ?>
  </head>
  <body>
  <?php
    require ROOT_PATH.'/includes/header.inc.php';
  ?>

  <div id="list">
      <h2>帖子列表</h2>

  </div>

  <?php
  require ROOT_PATH.'/includes/menu.inc.php';
  ?>

  <?php
    require ROOT_PATH.'/includes/footer.inc.php';

  ?>

  </body>
</html>