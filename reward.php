<?php
/**
 * Created by PhpStorm.
 * User: ljl
 * Date: 2016/6/28
 * Time: 17:04
 */
define('IN_TG',true);
define('SCRIPT','reward');
require 'common.inc.php';
include  ROOT_PATH.'/includes/activity.func.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title></title>
    <?php
    require ROOT_PATH.'/includes/title.inc.php';
    ?>
    <script type="text/javascript" src="js/reward.js"></script>
</head>
<body>
<div id="guize">
    <h1>参与讨论步骤：</h1>
    <p>1、关注中国科普博览或者kepubolan微信公众号</p><br />
    <p>2、发送“self”进行签到</p><br />
    <p>3、签到成功即可发送消息进行互动讨论</p>
</div>

</body>
</html>