<?php
/**
 * Created by PhpStorm.
 * User: ljl
 * Date: 2016/6/21
 * Time: 10:47
 */
session_start();
//防止恶意调用
define('IN_TG',true);
//定义一个常量，指定本页内容
define('SCRIPT','activity');
//引用公共文件
require 'common.inc.php';
//判断登录状态
if(!_login_state()) {
    _location('您还未登录，请您登陆后使用','login.php');
}

if(@$_GET['action'] == 'activity') {
    require ROOT_PATH.'/includes/activity.func.php';
    $_clean = array();
    $_clean['activityname'] = _check_activityName($_POST['activityname'], 2, 20);
    $_clean['uniqid'] = _check_uniqids($_POST['uniqid']);
    $_clean['screentitle'] = _check_screenTitle($_POST['screentitle'], 1, 15);
    $_clean['starttime'] = $_POST['starttime'];
    $_clean['endtime'] = $_POST['endtime'];
    $_clean['methodes'] = $_POST['methodes'];
    $_clean['subscribe'] = _check_subscribe($_POST['subscribe']);
    _is_repeat(
        $_connect,
        "SELECT tg_activityname from tg_activity where tg_activityname='{$_clean['activityname']}' LIMIT 1",
        '对不起，此活动名称已被使用'
    );
    _is_repeat(
        $_connect,
        "SELECT tg_uniqid from tg_activity where tg_uniqid='{$_clean['uniqid']}' LIMIT 1",
        '对不起，此活动唯一标识已被使用'
    );
    $username = $_COOKIE['username'];
    _query($_connect, "INSERT INTO tg_activity(
                                            tg_username,
                                            tg_activityname,
                                            tg_uniqid,
                                            tg_title,
                                            tg_starttime,
                                            tg_endtime,
                                            tg_method,
                                            tg_subscribe,
                                            tg_createtime
                                      )
                                      VALUES(
                                           '{$username}' ,
                                            '{$_clean['activityname']}',
                                            '{$_clean['uniqid']}',
                                            '{$_clean['screentitle']}',
                                            '{$_clean['starttime']}',
                                            '{$_clean['endtime']}',
                                            '{$_clean['methodes']}',
                                            '{$_clean['subscribe']}',
                                            NOW()
                                      )"
    );
    if (_affected_rows($_connect) == 1) {
        _close($_connect);
        //跳转
        _location('恭喜你添加成功！', 'activityList.php');
    } else {
        _close($_connect);
        //跳转
        _location('很遗憾添加失败!', 'activity.php');
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
    <title>发布活动</title>
    <link rel="shortcut icon" href="favicon.ico" />
    <?php
        require ROOT_PATH.'/includes/title.inc.php';
    ?>
    <script type="text/javascript" src="js/activity.js" ></script>
</head>
<body>
<?php
require ROOT_PATH.'/includes/header.inc.php';
?>
<div id="activity">
    <h2>发布活动</h2>
    <form method="post" name="activity" action="activity.php?action=activity" >
        <dl>
            <dt>请认真填写以下内容，所有内容为必填项</dt>
            <dd>活动名称：<input type="text" name="activityname" class="text" /><p>*活动名称不能为空</p></dd>
            <dd>唯一标识：<input type="text" name="uniqid" class="text" /><p>*必须为3至8位英文字母组成</p></dd>
            <dd>屏幕标题：<input type="text" name="screentitle" class="text" /><p>*大屏幕标题不能为空</p></dd>
            <dd>开始时间：<input type="datetime-local" name="starttime" class="date"/> </dd>
            <dd>结束时间：<input type="datetime-local" name="endtime" class="date" /></dd>
            <dd>签到方式：<input type="radio" name="signOrders" value="1" checked="checked"/>唯一标识<input type="radio" name="signOrders" value="0" disabled/>唯一标识+姓名</dd>
            <dd>关注提示：<textarea rows="4" cols="40" name="subscribe" >感谢您的关注，请输入签到命令进行签到，签到成功即可参与大屏幕讨论。</textarea></dd>
            <dd><input type="submit" class="submit" value="提交" /></dd>
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