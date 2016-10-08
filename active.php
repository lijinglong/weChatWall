<?php
/**
 * Created by PhpStorm.
 * User: ljl
 * Date: 2016/6/20
 * Time: 10:52
 */
//防止恶意调用
define('IN_TG',true);
//第一一个常量，指定本页内容
define('SCRIPT','active');
//引用公共文件
require 'common.inc.php';
//开始激活处理
if(!isset($_GET['active'])){
    _alert_back('非法操作');
}
if(isset($_GET['action']) && isset($_GET['active']) && $_GET['action'] == 'ok'){
    echo '开始激活';
    $_active = _mysql_string($_GET['active']);
    if(_fetch_array($_connect,"SELECT tg_active from tg_user where tg_active='$_active' LIMIT 1")){
        //将tg_active设置为空
        _query($_connect,"UPDATE tg_user set tg_active='' where tg_active='$_active' LIMIT 1");
        if(_affected_rows($_connect) == 1) {
            _close($_connect);
            _location('账户激活成功','login.php');
        }else {
            _close($_connect);
            _location('账户激活失败','register.php');
        }
    }else {
        _alert_back('非法操作');
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
    <title>多用户留言系统注册--激活</title>
    <link rel="shortcut icon" href="favicon.ico" />
    <?php
    require ROOT_PATH.'/includes/title.inc.php';
    ?>
    <script type="text/javascript" src="js/register.js"></script>
</head>
<body>
<?php
require ROOT_PATH.'/includes/header.inc.php';
?>
<div id="active">
    <h2>激活账户</h2>
    <p>本页面是模拟您的邮件功能，点击以下链接，激活您的账户</p>
    <p><a href="active.php?action=ok&amp;active=<?php  echo $_GET['active']; ?>"><?php echo 'http://'.$_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"]?>active.php?action=ok&amp;active=<?php  echo $_GET['active']; ?></a></p>
</div>

<?php
require ROOT_PATH.'/includes/footer.inc.php';
?>
</body>
</html>