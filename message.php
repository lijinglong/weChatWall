<?php
/**
 * Created by PhpStorm.
 * User: ljl
 * Date: 2016/8/10
 * Time: 13:09
 */
//防止恶意调用
define('IN_TG',true);
//定义一个常量指定本页内容
define('SCRIPT','message');
//将php错误信息输出在页面
ini_set("display_errors", "On");
error_reporting(E_ALL | E_STRICT);
//引用公共文件
require 'common.inc.php';
require 'qqface.php';
//判断登录状态
if(!_login_state()){
    _alert_back('请登陆之后进行操作');
}
$uniqid = $_GET['uniqid'];
if(isset($_GET['del'])=='ok'){
    $tg_id = $_GET['tg_id'];
    _query($_connect,"delete from weichat WHERE tg_id='$tg_id'");
    if(_affected_rows($_connect)==1){
        _close($_connect);
        _location('删除成功','message.php?uniqid='.$uniqid);
    }else{
        _close($_connect);
        _location('删除失败','message.php?uniqid='.$uniqid);
    }
}
global $_pagesize,$_pagenum;
_page($_connect,"SELECT tg_id from weichat WHERE  tg_uniqid='$uniqid'",10);
//首页要得到所有的数据总和
//从数据库里提取数据获取结果集
//我们必须是每次重新读取结果集，而不是从新去执行SQL语句
$result = _query($_connect,"SELECT * from weichat WHERE tg_uniqid='$uniqid' ORDER BY tg_createtime DESC LIMIT $_pagenum,$_pagesize");
$rows = mysqli_num_rows($result);
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
    <h2>消息列表</h2>
    <table cellpadding="2" cellspacing="1">
        <tr style="font-weight: bold">
            <td>头像</td>
            <td>昵称</td>
            <td>发送内容</td>
            <td>发送时间</td>
            <td style="border-right: solid 1px">操作</td>
        </tr>
        <?php
        for($i=0;$i<$rows;$i++){
            $row = mysqli_fetch_assoc($result);
            $times = timestampToTime($row["tg_createtime"],'Y-m-d H:i:s');
            $id= $row['tg_id'];
            $uni = $row['tg_uniqid'];
            if($i == ($rows-1)){
        ?>
                <tr>
                    <td style="border-bottom: solid 1px"><img src="<?php echo $row["tg_headimgurl"];?>"</td>
                    <td style="border-bottom: solid 1px"><?php echo $row["tg_fromusername"];?></td>
                    <?php
                        if($row['tg_msgtype']=='image'){
                    ?>
                            <td style="border-bottom: solid 1px"><img id="piccontent" src="<?php echo $row["tg_picurl"];?>"</td>
                    <?php
                        }else{
                    ?>
                            <td style="border-bottom: solid 1px"><?php echo qqface_convert_html($row["tg_content"]);?></td>
                    <?php
                        }
                    ?>
                    <td style="border-bottom: solid 1px"><?php echo $times;?></td>
                    <td style="border-right: solid 1px;border-bottom: solid 1px"><input id="del" type="button" onclick="deleteInfo(<?php echo $id;?>,'<?php echo $uni;?>','确定删除用户发送的消息？','<?php echo SCRIPT;?>')" value="删除"></td>
                </tr>
        <?php
            }else {
        ?>
                <tr>
                    <td><img src="<?php echo $row["tg_headimgurl"];?>"</td>
                    <td><?php echo $row["tg_fromusername"];?></td>
                    <?php
                    if($row['tg_msgtype']=='image'){
                        ?>
                        <td><img id="piccontent" src="<?php echo $row["tg_picurl"];?>"</td>
                    <?php
                    }else{
                        ?>
                        <td><?php echo qqface_convert_html($row["tg_content"]);?></td>
                    <?php
                    }
                    ?>
                    <td><?php echo $times;?></td>
                    <td style="border-right: solid 1px"><input id="del" type="button" onclick="deleteInfo(<?php echo $id;?>,'<?php echo $uni;?>','确定删除用户发送的消息？','<?php echo SCRIPT;?>')" value="删除"></td>
                </tr>
        <?php
            }
        }
        ?>
    </table>
    <?php _paging(2,$uniqid); ?>
</div>

<?php
require ROOT_PATH.'/includes/menu.inc.php';
?>

<?php
require ROOT_PATH.'/includes/footer.inc.php';

?>

</body>
</html>