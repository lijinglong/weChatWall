<?php
/**
 * Created by PhpStorm.
 * User: ljl
 * Date: 2016/7/21
 * Time: 9:24
 */
define('IN_TG',true);
define('SCRIPT','userList');
require 'common.inc.php';
//判断登录状态
if(!_login_state()){
    _alert_back('请登陆之后进行操作');
}
$uniqid = $_GET['uniqid'];
if(isset($_GET['del'])=='ok'){
    $tg_id = $_GET['tg_id'];
    _query($_connect,"delete from tg_subcribe WHERE tg_id='$tg_id'");
    if(_affected_rows($_connect)==1){
        _close($_connect);
        _location('删除成功','userList.php?uniqid='.$uniqid);
    }else{
        _close($_connect);
        _location('删除失败','userList.php?uniqid='.$uniqid);
    }
}
global $_pagesize,$_pagenum;
_page($_connect,"SELECT tg_id from tg_subcribe WHERE  tg_uniqid='$uniqid'",10);
//首页要得到所有的数据总和
//从数据库里提取数据获取结果集
//我们必须是每次重新读取结果集，而不是从新去执行SQL语句
$result = _query($_connect,"SELECT * from tg_subcribe WHERE tg_uniqid='$uniqid' ORDER BY tg_subtime DESC LIMIT $_pagenum,$_pagesize");
$num_rows = mysqli_num_rows($result);
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
        <h2>用户列表</h2>
        <table cellpadding="2" cellspacing="1">
            <?php
                if($num_rows == 0){
            ?>
                    <tr style="font-weight: bold;">
                        <td style="border-bottom: solid 1px">头像</td>
                        <td style="border-bottom: solid 1px">昵称</td>
                        <td style="border-bottom: solid 1px">签到时间</td>
                        <td style="text-align: center;border-right: 1px solid; border-bottom: solid 1px">操作</td>
                    </tr>
            <?php
                }else {
            ?>
                    <tr style="font-weight: bold;">
                        <td>头像</td>
                        <td>昵称</td>
                        <td>签到时间</td>
                        <td style="text-align: center;border-right: 1px solid">操作</td>
                    </tr>
             <?php
                }
             for($i=0;$i<$num_rows;$i++) {
                 $row = mysqli_fetch_assoc($result);
                 $id= $row['tg_id'];
                 $subtime = timestampToTime($row["tg_subtime"],'Y-m-d');
                 if($i == ($num_rows-1)){
                  ?>
                     <tr>
                         <td style="border-bottom: solid 1px"><img src="<?php echo $row["tg_headimgurl"]; ?>"></td>
                         <td style="border-bottom: solid 1px"><?php echo $row["tg_nickname"]; ?></td>
                         <td style="border-bottom: solid 1px"><?php echo $subtime; ?></td>
                         <td style="text-align: center; border-bottom: solid 1px;border-right: solid 1px"><input type="button" onclick="deleteInfo(<?php echo $id;?>,'<?php echo $uniqid;?>','确定删除此条用户信息？','<?php echo SCRIPT;?>')" value="移除"/></td>
                     </tr>
                 <?php
                 }else {
                 ?>
                 <tr>
                     <td><img src="<?php echo $row["tg_headimgurl"]; ?>"></td>
                     <td><?php echo $row["tg_nickname"]; ?></td>
                     <td><?php echo $subtime; ?></td>
                     <td style="text-align: center;border-right: solid 1px"><input type="button" onclick="deleteInfo(<?php echo $id;?>,'<?php echo $uniqid;?>','确定删除此条用户信息？','<?php echo SCRIPT;?>')" value="移除"/></td>
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