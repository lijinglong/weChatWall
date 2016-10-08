<?php
/**
 * Created by PhpStorm.
 * User: ljl
 * Date: 2016/8/16
 * Time: 10:18
 */
//防止非法调用
define("IN_TG",true);
define("SCRIPT",'activityEdit');
//将php错误信息输出在页面
ini_set("display_errors", "On");
error_reporting(E_ALL | E_STRICT);
//引用公共文件
require 'common.inc.php';
//判断登录状态
if(!_login_state()) {
    _location('您还未登录，请您登陆后使用','login.php');
}
$_uniqid = $_GET['uniqid'];
$_result = _query($_connect,"SELECT * from tg_activity WHERE tg_uniqid='$_uniqid' LIMIT 1");
$_resultStr = mysqli_fetch_assoc($_result);
$_id = $_resultStr['tg_id'];
$_activityName = $_resultStr['tg_activityname'];
$_title = $_resultStr['tg_title'];
$_startTime = $_resultStr['tg_starttime'];
$_endTime = $_resultStr['tg_endtime'];
$_subscribe = $_resultStr['tg_subscribe'];
if($_resultStr['tg_method'] == 0){
    $_method = $_resultStr['tg_uniqid'];
}
if(@$_GET['action'] == 'activityEdit'){
    require ROOT_PATH.'/includes/activity.func.php';
    $_clean = array();
    $_clean['activityname'] = _check_activityName($_POST['activityName'], 2, 20);
    $_clean['uniqid'] = _check_uniqids($_POST['uniqid']);
    $_clean['screentitle'] = _check_screenTitle($_POST['title'], 1, 15);
    $_clean['starttime'] = $_POST['startTime'];
    $_clean['endtime'] = $_POST['endTime'];
    $_clean['subscribe'] = _check_subscribe($_POST['subscribe']);
    if($_clean['activityname'] != $_activityName){
        _is_repeat(
            $_connect,
            "SELECT tg_activityname from tg_activity WHERE tg_activityname='{$_clean['activityname']}' LIMIT 1",
            '对不起，此活动名称已被使用'
        );
        _query($_connect,"update tg_activity set tg_activityname='{$_clean['activityname']}' WHERE tg_id='$_id' LIMIT 1");
        _query($_connect,"update tg_subcribe set tg_activityname='{$_clean['activityname']}'WHERE tg_uniqid='$_uniqid'");
        $_activityName = $_clean['activityname'];
    }
    if($_clean['uniqid'] != $_uniqid){
        _is_repeat(
            $_connect,
            "SELECT tg_uniqid from tg_activity WHERE tg_uniqid='{$_clean['uniqid']}' LIMIT 1",
            '对不起，此活动唯一标识已被使用'
        );
        _query($_connect,"update tg_activity set tg_uniqid='{$_clean['uniqid']}' WHERE tg_id='$_id' LIMIT 1");
        _query($_connect,"update tg_subcribe set tg_uniqid='{$_clean['uniqid']}'WHERE tg_uniqid='$_uniqid'");
        _query($_connect,"update weichat set tg_uniqid='{$_clean['uniqid']}'WHERE tg_uniqid='$_uniqid'");
        $_uniqid = $_clean['uniqid'];
        $_method = $_uniqid;
    }
    if($_clean['screentitle'] != $_title){
        _query($_connect,"update tg_activity set tg_title='{$_clean['screentitle']}' WHERE tg_id='$_id' LIMIT 1");
        $_title = $_clean['screentitle'];
    }
    if($_clean['starttime'] != $_startTime){
        _query($_connect,"update tg_activity set tg_starttime='{$_clean['starttime']}' WHERE tg_id='$_id' LIMIT 1");
        $_startTime = $_clean['starttime'];
    }
    if($_clean['endtime'] != $_endTime){
        _query($_connect,"update tg_activity set tg_endtime='{$_clean['endtime']}' WHERE tg_id='$_id' LIMIT 1");
        $_endTime = $_clean['endtime'];
    }
    if($_clean['subscribe'] != $_subscribe){
        _query($_connect,"update tg_activity set tg_subscribe='{$_clean['subscribe']}' WHERE tg_id='$_id' LIMIT 1");
        $_subscribe = $_clean['subscribe'];
    }
    if (_affected_rows($_connect) == 1) {
        _location('保存成功！','activityEdit.php?uniqid='.$_uniqid);
    }else{
        _location('保存失败！','activityEdit.php?uniqid='.$_uniqid);
    }

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
    <title>微信墙系统·编辑活动</title>
    <?php
    require ROOT_PATH.'/includes/title.inc.php';
    ?>
    <script type="text/javascript" src="js/member.js"></script>
</head>
<body>
<?php
require ROOT_PATH.'/includes/header.inc.php';
?>

<div id="activityEdit">
    <h2>活动详情</h2>
    <form method="post" name="activityEdit" action="activityEdit.php?action=activityEdit&uniqid=<?php echo $_uniqid; ?>">
        <dl>
            <dd>活动名称：<input type="text" name="activityName" value="<?php echo $_activityName; ?>"/></dd>
            <dd>唯一标识：<input typw="text" name="uniqid" value="<?php echo $_uniqid; ?>"/></dd>
            <dd>屏幕标题：<input type="text" name="title" value="<?php echo $_title; ?>"/></dd>
            <dd>开始时间：<input type="datetime-local" name="startTime" value="<?php echo $_startTime;?>"/></dd>
            <dd>结束时间：<input type="datetime-local" name="endTime" value="<?php echo $_endTime;?>"/></dd>
            <dd>签到命令：<?php echo $_method;?></dd>
            <dd class="textarea">关注提示：<textarea rows="4" cols="40"  name="subscribe"><?php echo $_subscribe; ?></textarea></dd>
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