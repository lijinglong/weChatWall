<?php
/**
 * Created by PhpStorm.
 * User: ljl
 * Date: 2016/6/29
 * Time: 13:24
 */
//防止恶意调用
define('IN_TG',true);
//定义一个常量指定本页内容
define('SCRIPT','activityList');
//引用公共文件
require 'common.inc.php';
//判断登录状态
if(!_login_state()) {
    _location('您还未登录，请您登陆后使用','login.php');
}
if(isset($_GET['del'])=='ok') {
    $tg_id = $_GET['tg_id'];
    $tg_uniqid = $_GET['uniqid'];
    _query($_connect,"delete from tg_subcribe WHERE tg_uniqid='$tg_uniqid'");
    _query($_connect,"delete from weichat WHERE  tg_uniqid='$tg_uniqid'");
    _query($_connect, "delete from tg_activity WHERE tg_id='$tg_id'");
    if (_affected_rows($_connect) == 1) {
        _close($_connect);
        _location('删除成功', 'activityList.php');
    } else {
        _close($_connect);
        _location('删除失败', 'activityList.php');
    }
}
//分页模块
global $_pagesize,$_pagenum;
if(isset($_COOKIE['flag'])==1){
    _page($_connect,"SELECT tg_id from tg_activity",10);   //第一个参数获取总条数，第二个参数，指定每页多少条
//首页要得到所有的数据总和
//从数据库里提取数据获取结果集
//我们必须是每次重新读取结果集，而不是从新去执行SQL语句
    if(isset($_GET['username'])){
        $_result = _query($_connect,"SELECT tg_id,tg_activityname,tg_uniqid,tg_username,tg_createtime from tg_activity WHERE tg_username='{$_GET['username']}'ORDER BY tg_createtime DESC  LIMIT $_pagenum,$_pagesize");
    }else{
        $_result = _query($_connect,"SELECT tg_id,tg_activityname,tg_uniqid,tg_username,tg_createtime from tg_activity ORDER BY tg_createtime DESC  LIMIT $_pagenum,$_pagesize");
    }
}else{
    $username = $_COOKIE['username'];
    _page($_connect,"SELECT tg_id FROM tg_activity WHERE tg_username='$username'",10);   //第一个参数获取总条数，第二个参数，指定每页多少条
//首页要得到所有的数据总和
//从数据库里提取数据获取结果集
//我们必须是每次重新读取结果集，而不是从新去执行SQL语句
    $_result = _query($_connect,"SELECT tg_id,tg_activityname,tg_uniqid,tg_username,tg_createtime from tg_activity WHERE tg_username='$username'ORDER BY tg_createtime DESC  LIMIT $_pagenum,$_pagesize");
}
$num_rows = mysqli_num_rows($_result);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
        <title>多用户留言系统首页</title>
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
        <h2>活动列表</h2>
        <table cellpadding="2" cellspacing="1" >
            <tr style="font-weight: bold">
                <td>活动名称</td>
                <td>签到命令</td>
                <td>创建时间</td>
                <td>创建者</td>
                <td>大屏幕地址</td>
                <td style="border-right: solid 1px">操作</td>
            </tr>
            <?php
            for($i=0;$i<$num_rows;$i++) {
                $row = mysqli_fetch_assoc($_result);
                $id = $row['tg_id'];
                $uniqid = $row['tg_uniqid'];
                if($i == ($num_rows-1)){
                    ?>
                    <tr>
                        <td style="border-bottom: solid 1px"><?php echo $row["tg_activityname"];?></td>
                        <td style="border-bottom: solid 1px"><?php echo $row["tg_uniqid"];?></td>
                        <td style="border-bottom: solid 1px"><?php echo $row["tg_createtime"];?></td>
                        <td style="border-bottom: solid 1px"><?php echo $row["tg_username"];?></td>
                        <td style="border-bottom: solid 1px"><a href="screen.php?uniqid=<?php echo $row['tg_uniqid'];?>">大屏幕</a> </td>
                        <td style="border-right: solid 1px;border-bottom: solid 1px"><a href="userList.php?uniqid=<?php echo $row['tg_uniqid'];?>">用户</a>|<a href="message.php?uniqid=<?php echo $row['tg_uniqid'];?>">消息</a>|<a href="activityEdit.php?uniqid=<?php echo $row['tg_uniqid']?>">编辑</a>|<input type="button" onclick="deleteInfo(<?php echo $id;?>,'<?php echo $uniqid;?>','活动用户信息与发送的消息将与活动信息一同删除，是否继续删除活动？','<?php echo SCRIPT;?>')" value="删除"/></td>
                    </tr>
                    <?php
                }else {
                    ?>
                    <tr>
                        <td><?php echo $row["tg_activityname"];?></td>
                        <td><?php echo $row["tg_uniqid"];?></td>
                        <td><?php echo $row["tg_createtime"];?></td>
                        <td><?php echo $row["tg_username"];?></td>
                        <td><a href="screen.php?uniqid=<?php echo $row['tg_uniqid'];?>">大屏幕</a> </td>
                        <td style="border-right: solid 1px"><a href="userList.php?uniqid=<?php echo $row['tg_uniqid'];?>">用户</a>|<a href="message.php?uniqid=<?php echo $row['tg_uniqid'];?>">消息</a>|<a href="activityEdit.php?uniqid=<?php echo $row['tg_uniqid']?>">编辑</a>|<input type="button" onclick="deleteInfo(<?php echo $id;?>,'<?php echo $uniqid;?>','活动用户信息与发送的消息将与活动信息一同删除，是否继续删除活动？','<?php echo SCRIPT;?>')" value="删除"/> </td>
                    </tr>
                    <?php
                }
            }
            ?>
        </table>
        <?php _paging(2,'');?>
    </div>

    <?php
    require ROOT_PATH.'/includes/menu.inc.php';
    ?>

    <?php
    require ROOT_PATH.'/includes/footer.inc.php';

    ?>

</body>
</html>