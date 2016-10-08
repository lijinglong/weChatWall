<?php
/**
 * Created by PhpStorm.
 * User: ljl
 * Date: 2016/8/16
 * Time: 14:41
 */
define('IN_TG',true);
define('SCRIPT','manager');
require 'common.inc.php';
//判断登录状态
if(!_login_state()){
    _alert_back('请登陆之后进行操作');
}
if(@$_GET['uniqid']=='delete'){
    $result = _fetch_array($_connect,"select tg_username,tg_flag from tg_user WHERE tg_id='{$_GET['tg_id']}' LIMIT 1");
    if($result['tg_flag'] == 1){
        _location('不能删除管理员','manager.php');
    }else{
        $result2 = _fetch_array($_connect,"select tg_uniqid from tg_activity WHERE tg_username='{$result['tg_username']}' LIMIT 1");
        _query($_connect,"delete from tg_subcribe where tg_uniqid='{$result2['tg_uniqid']}'");
        _query($_connect,"delete from weichat where tg_uniqid='{$result2['tg_uniqid']}'");
        _query($_connect,"delete from tg_activity where tg_uniqid='{$result2['tg_uniqid']}'");
        _query($_connect,"delete from tg_user where tg_id='{$_GET['tg_id']}'");
        if (_affected_rows($_connect) == 1) {
            _location('删除成功', 'manager.php');
        }else{
            _location('删除失败', 'manager.php');
        }
    }
}
if(@$_GET['uniqid']=='reset'){
    $_pass = sha1('12345678');
    _query($_connect,"update tg_user set tg_password='$_pass' WHERE tg_id='{$_GET['tg_id']}'");
    if (_affected_rows($_connect) == 1) {
        _location('重置密码成功', 'manager.php');
    }else{
        _location('重置密码失败', 'manager.php');
    }
}
global $_pagesize,$_pagenum;
_page($_connect,"SELECT tg_id from tg_user",10);
$_result = _query($_connect,"select * from tg_user");
$num_rows = mysqli_num_rows($_result);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
    <title></title>
    <link rel="shortcut icon" href="favicon.ico"/>
    <?php
    require ROOT_PATH.'/includes/title.inc.php';
    ?>
    <script type="text/javascript" src="js/common.js"></script>
</head>
<body>
<?php
require ROOT_PATH.'/includes/header.inc.php';
?>
<div id="list">
    <h2>管理用户</h2>
    <table cellpadding="2" cellspacing="1">
        <?php
        if($num_rows == 0){
            ?>
            <tr style="font-weight: bold;">
                <td style="border-bottom: solid 1px">头像</td>
                <td style="border-bottom: solid 1px">用户名</td>
                <td style="border-bottom: solid 1px">性别</td>
                <td style="border-bottom: solid 1px">邮箱</td>
                <td style="border-bottom: solid 1px">注册时间</td>
                <td style="text-align: center;border-right: 1px solid; border-bottom: solid 1px">操作</td>
            </tr>
        <?php
        }else {
            ?>
            <tr style="font-weight: bold;">
                <td>头像</td>
                <td>用户名</td>
                <td>性别</td>
                <td>邮箱</td>
                <td>注册时间</td>
                <td style="text-align: center;border-right: 1px solid">操作</td>
            </tr>
        <?php
        }
        for($i=0;$i<$num_rows;$i++) {
            $row = mysqli_fetch_assoc($_result);
            $_id= $row['tg_id'];
            if($i == ($num_rows-1)){
                ?>
                <tr>
                    <td style="border-bottom: solid 1px"><img src="<?php echo $row["tg_face"]; ?>"></td>
                    <td style="border-bottom: solid 1px"><?php echo $row["tg_username"]; ?></td>
                    <td style="border-bottom: solid 1px"><?php echo $row["tg_sex"]; ?></td>
                    <td style="border-bottom: solid 1px"><?php echo $row["tg_email"]; ?></td>
                    <td style="border-bottom: solid 1px"><?php echo $row['tg_reg_time']; ?></td>
                    <td style="text-align: center; border-bottom: solid 1px;border-right: solid 1px"><a href="activityList.php?username=<?php echo $row['tg_username'];?>">查看活动</a>|<input type="button" onclick="deleteInfo(<?php echo $_id;?>,'reset','是否重置用户密码？','manager')" value="重置密码"/>|<input type="button" onclick="deleteInfo(<?php echo $_id;?>,'delete','确定删除此用户？','manager')" value="移除"/></td>
                </tr>
            <?php
            }else {
                ?>
                <tr>
                    <td><img src="<?php echo $row["tg_face"]; ?>"></td>
                    <td><?php echo $row["tg_username"]; ?></td>
                    <td><?php echo $row["tg_sex"]; ?></td>
                    <td><?php echo $row["tg_email"]; ?></td>
                    <td><?php echo $row['tg_reg_time']; ?></td>
                    <td style="text-align: center;border-right: solid 1px"><a href="activityList.php?username=<?php echo $row['tg_username'];?>">查看活动</a>|<input type="button" onclick="deleteInfo(<?php echo $_id;?>,'reset','是否重置用户密码？','manager')" value="重置密码"/>|<input type="button" onclick="deleteInfo(<?php echo $_id;?>,'delete','确定删除此用户？','manager')" value="移除"/></td>
                </tr>
            <?php
            }
        }
        ?>
    </table>
    <?php _paging(2,''); ?>
</div>

<?php
require ROOT_PATH.'/includes/menu.inc.php';
?>
<?php
require ROOT_PATH.'/includes/footer.inc.php';
?>

</body>
</html>