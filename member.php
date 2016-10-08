<?php
/**
 * Created by PhpStorm.
 * User: ljl
 * Date: 2016/7/26
 * Time: 13:21
 */
//防止非法调用
define("IN_TG",true);
define("SCRIPT",'member');
//引用公共文件
require 'common.inc.php';
//判断登录状态
if(!_login_state()) {
    _location('您还未登录，请您登陆后使用','login.php');
}
$_username = $_GET['username'];
$_result = _query($_connect,"SELECT * from tg_user WHERE tg_username='$_username' LIMIT 1");
$resultstr = mysqli_fetch_assoc($_result);
$_id = $resultstr['tg_id'];
$_user = $resultstr['tg_username'];
$_sex = $resultstr['tg_sex'];
$_face = $resultstr['tg_face'];
$_email = $resultstr['tg_email'];
$_qq = $resultstr['tg_qq'];
if(@$_GET['action']=='member'){
    include ROOT_PATH.'/includes/register.func.php';
    $_clean = array();
    $_clean['username'] = _check_username($_POST['username'],2,20);
    $_clean['sex'] = $_POST['sex'];
    $_clean['face'] = $_POST['face'];
    $_clean['email'] = _check_email($_POST['email'],6,40);
    $_clean['qq'] = _check_qq($_POST['qq']);
    if( $_clean['username'] != $_user){
        _is_repeat(
            $_connect,
            "SELECT tg_username from tg_user where tg_username='{$_clean['username']}' LIMIT 1",
            '对不起，此用户已被注册!'
        );
        _query($_connect,"update tg_user set tg_username='{$_clean['username']}'WHERE tg_id='$_id' LIMIT 1");
        _query($_connect,"update tg_activity set tg_username='{$_clean['username']}'WHERE tg_username='$_user'");
        setcookie('username',$_clean['username']);
        $_user=$_clean['username'];
    }
    if($_clean['sex']!= $_sex){
        _query($_connect,"update tg_user set tg_sex='{$_clean['sex']}' WHERE tg_id='$_id' LIMIT 1");
        $_sex = $_clean['sex'];
    }
    if($_clean['face']!= $_face){
        _query($_connect,"update tg_user set tg_face='{$_clean['face']}' WHERE tg_id='$_id' LIMIT 1");
        $_face = $_clean['face'];
    }
    if($_clean['email'] != $_email){
        _query($_connect,"update tg_user set tg_email='{$_clean['email']}' WHERE tg_id='$_id' LIMIT 1");
        $_face = $_clean['email'];
    }
    if($_clean['qq'] != $_qq){
        _query($_connect,"update tg_user set tg_qq='{$_clean['qq']}' WHERE tg_id='$_id' LIMIT 1");
        $_face = $_clean['qq'];
    }
    if (_affected_rows($_connect) == 1) {
        _location('保存成功','member.php?username='.$_user);
    }else{
        _location('保存失败','member.php?username='.$_user);
    }
}

$_reg_time = $resultstr['tg_reg_time'];
if($resultstr['tg_flag']==1){
    $_identify = '管理员';
}else{
    $_identify = '普通用户';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
    <title>微信墙系统·个人中心</title>
    <?php
    require ROOT_PATH.'/includes/title.inc.php';
    ?>
    <script type="text/javascript" src="js/member.js"></script>
</head>
<body>
<?php
require ROOT_PATH.'/includes/header.inc.php';
?>

<div id="member">
    <h2>个人资料</h2>
    <form method="post" name="member" action="member.php?action=member&username=<?php echo $_username;?>">
        <dl>
            <dd>用 户 名：<input type="text" name="username" value="<?php echo $_user; ?>"/></dd>
            <dd>性　　别：<input typw="text" name="sex" value="<?php echo $_sex; ?>"/></dd>
            <dd class="face">头　　像：<input type="hidden" name="face" value="<?php echo $_face;?>"/><img src="<?php echo $_face;?>" alt="头像选择" id="faceimg"/></dd>
            <dd>电子邮件：<input type="text" name="email" value="<?php echo $_email; ?>"/></dd>
            <dd>Q 　 　Q：<input type="text" name="qq" value="<?php echo $_qq;?>"/></dd>
            <dd>注册时间：<?php echo $_reg_time;?></dd>
            <dd>身　　份：<?php echo $_identify;?></dd>
            <dd><input type="submit" class="submit" name="save" value="保存"/></dd>
        </dl>
    </form>

</div>

<?php
require ROOT_PATH.'/includes/menu.inc.php';
?>

<?php
require ROOT_PATH.'/includes/footer.inc.php';

?>
</body>
</html>