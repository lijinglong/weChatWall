<?php
/**
 * Created by PhpStorm.
 * User: ljl
 * Date: 2016/6/15
 * Time: 15:54
 */
session_start();

//防止恶意调用
define('IN_TG',true);
//第一一个常量，指定本页内容
define('SCRIPT','login');
//引用公共文件
require 'common.inc.php';
//登录状态的判断
_login_state();
//开始处理登录状态
if(@$_GET['action'] == 'login'){
    //为了防止恶意注册，跨站攻击
    _check_code(@$_POST['code'],@$_SESSION['code']);
    //引入验证文件
    include ROOT_PATH.'/includes/login.func.php';
    $_clean = array();
    $_clean['username'] = _check_username($_POST['username'],2,20);
    $_clean['password'] = _check_password($_POST['password'],6);
    $_clean['time'] = _check_time($_POST['time']);
    //到数据库验证
    if(!!$_rows = _fetch_array($_connect,"SELECT * from tg_user where tg_username='{$_clean['username']}' AND tg_password='{$_clean['password']}'AND tg_active='' LIMIT 1")) {
        _close($_connect);
        _session_destroy();
        _setcookies($_rows['tg_username'],$_rows['tg_uniqid'],$_clean['time'],$_rows['tg_flag']);
        _location(null,'index.php');
    }else {
        echo 'failed';
        _close($_connect);
        _session_destroy();
        _location('用户名密码不正确，或者该账户未激活','login.php');
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
    <title>多用户留言系统--登录</title>
    <link rel="shortcut icon" href="favicon.ico" />
    <?php
    require ROOT_PATH.'/includes/title.inc.php';
    ?>
    <script type="text/javascript" src="js/code.js"></script>
    <script type="text/javascript" src="js/login.js"></script>
</head>
<body>
<?php
require ROOT_PATH.'/includes/header.inc.php';
?>

<div id="login">
    <h2>登录</h2>
    <form method="post" name="login" action="login.php?action=login">
        <dl>
            <dt>请认真填写以下内容</dt>
            <dd>用 户 名：<input type="text" name="username" class="text" /></dd>
            <dd>密 &nbsp;  码：<input type="password" name="password" class="text" /></dd>
            <dd>保&nbsp;   留:<input type="radio" name="time" value="0" checked="checked"/>不保留<input type="radio" name="time" value="1" />一天<input type="radio" name="time" value="2" />一周<input type="radio" name="time" value="3" />一月</dd>
            <dd>验 证 码：<input type="text" name="code" class="text code" /><img src="code.php" id="code" /> </dd>
            <dd><input type="submit" value="登录" class="button" /><input type="button" value="注册" id="location" class="button location" /></dd>
        </dl>
    </form>
</div>



<?php
require ROOT_PATH.'/includes/footer.inc.php';
?>
  </body>
</html>